<?php
namespace common\models;

use yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\behaviors\TimestampBehavior;
use common\models\queries\UserQuery;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $is_email_verified
 * @property string $password_reset_token
 * @property string $email_confirmation_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $password write-only password
 * @property string $avatar
 * @property UploadedFile $imageFile
 * @property string $password_rest_token
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;

    const ROLE_USER = 1;

    public $imageFile;

    /**
     * @var string|null the current password value from form input
     */
    protected $_password;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @return UserQuery custom query class with user scopes
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return array_merge(parent::scenarios(), [
            'signup' => ['username', 'email', 'phone', 'password', 'company'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'phone', 'password'], 'required', 'on' => 'signup'],
            ['username', 'match', 'pattern' => '/^[a-z]\w*$/i', 'on' => 'signup'],
            [
                'password', 'match', 'pattern' => '/\d/',
                'message' => '密码至少包含一位数字', 'on' => 'signup'
            ],
            [
                'password', 'match', 'pattern' => '/[a-zA-Z]/',
                'message' => '密码至少包含一个字母', 'on' => 'signup'
            ],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],

            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [self::ROLE_USER]],

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'unique', 'on' => 'signup'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'on' => 'signup'],
            ['company', 'filter', 'filter' => 'trim'],
            ['company', 'string', 'min' => 2, 'max' => 50],
            ['phone', 'string', 'max' => 15],
            [['phone'], 'match', 'pattern' => '/^[1][3578][0-9]{9}$/'],
            ['avatar', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'avatar' => Yii::t('app', 'avatar'),
            'id' => Yii::t('app', 'id'),
            'username' => Yii::t('app', 'username'),
            'email' => Yii::t('app', 'email'),
            'is_email_verified' => Yii::t('app', 'is email verified'),
            'password' => Yii::t('app', 'password'),
            'phone' => Yii::t('app', 'phone'),
            'company' => Yii::t('app', 'company'),
            'role' => Yii::t('app', 'role'),
            'status' => Yii::t('app', 'status'),
            'create_time' => Yii::t('app', 'create time'),
            'update_time' => Yii::t('app', 'update time'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->setPassword($this->password);
            $this->generateAuthKey();
            $this->generateEmailConfirmationToken();
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            try {
                $params = Yii::$app->params;
                Yii::$app->mail->compose(
                    'confirmEmail',
                    [
                        'user' => $this
                    ]
                )->setFrom(
                    [
                        $params['support.email'] => $params['support.name']
                    ]
                )->setTo($this->email)
                    ->setSubject('激活 ' . Yii::$app->name)
                    ->send();
            } catch (\Exception $e) {
                Yii::warning(
                    'Failed to send confirmation email to new user. No SMTP server configured?',
                    'app\models\User'
                );
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
        if (!empty($password)) {
            $this->password = Yii::$app->security->generatePasswordHash($password);
        }
    }

    /**
     * @return string|null the current password value, if set from form. Null otherwise.
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new email confirmation token
     * @param bool $save whether to save the record. Default is `false`.
     * @return bool|null whether the save was successful or null if $save was false.
     */
    public function generateEmailConfirmationToken()
    {
        $this->email_confirmation_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new password reset token
     * @param bool $save whether to save the record. Default is `false`.
     * @return bool|null whether the save was successful or null if $save was false.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Resets to a new password and deletes the password reset token.
     * @param string $password the new password for this user.
     * @return bool whether the record was updated successfully
     */
    public function resetPassword($password)
    {
        $this->setPassword($password);
        $this->password_reset_token = null;
        return $this->save();
    }

    /**
     * Confirms an email an deletes the email confirmation token.
     * @return bool whether the record was updated successfully
     */
    public function confirmEmail()
    {
        $this->email_confirmation_token = null;
        $this->is_email_verified = 1;
        return $this->save();
    }
}
