# 项目名称

> 该项目用于快速搭建API服务端及后台框架

> 内置持续集成, 实现了自动化代码审查、composer包依赖自动构建、自动化测试、Docker镜像打包和发布

## 开始

### 创建项目

#### 安装

  使用composer 创建

 `composer create-project zacksleo/yii2-app-advanced:^1.1.0 target-directory`

### 使用Docker创建运行环境

  使用 docker-compose 创建运行环境:

  ```
   docker-compose up

  ```

### 修改环境变量

  修改 docker-compose.yml中 nginx 和 mysql 暴露的接口, 如

  ```
      nginx:
          image: zacksleo/nginx
          ports:
              - "80:80"
          links:
              - web
          volumes_from:
              - web

      mysql:
          image: mysql:5.6
          ports:
              - "3306:3306"
  ```

  > 注意, 开发环境中, 可以暴露数据库接口到外网, 如果是正式环境,请关闭端口


### 数据库迁移

  迁移数据库

  ```
    docker exec -it yii2appadvanced_web_1 ./yii migrate/up

  ```
> `yii2appadvanced_web_1` 是容器的名称

   或者使用

   ```
    docker-compose run --rm web ./yii migrate/up

   ```
> 如果修改后台管理员账号和密码

   ```
   修改 console\migrations\m170406_084842_create_admin_account.php 中的 `username`和 `password_hash`来修改后台账号密码
   ```

### 编写接口

  在api/modules下建立版本号对应的模块, 例如v1, 在controllers 中编写控制器, 提供接口

  如果该接口需要认证, 可以继承 `api\modules\v1\controllers`, 该类中实现接口认证

  > api目录为接口目录, modules中以版本号区别各个模块, 如 `v1`,`v2`

  接口的访问地址为 `/api/v1`, v1 为版本号(模块名称)

### 配置URL

  RESTful接口需要配置URL, 该文件位置文件位于`api\modules\v1\config.php`中, 一个控制器配置一条数据

### 后台

  后台地址为 /admin, 默认的账号为 `admin`, 密码为 `admin`


### 目录说明

  + 如果是多个模块公用的模型, 放在 `common\models` 目录下
  + 如果仅仅某个模块使用, 放在该模块的`{api/backend/frontend}\models`目录下

  + 表单模型放在 `models\forms` 目录下
  + 查询模型放在 `models\queries` 目录下
  + 行为放在 `models\behaviors` 目录下
  + 帮助类放在 `common\helpers` 目录下
  + 过滤器: 通用的放在 `common\filters` 目录下, 某个模块的放在 `{api/backend/frontend}\filters`目录下
  + 测试: 所有测试代码放在 `tests` 目录下
  + 部署: 各个环境的部署脚本放在 `deploy` 目录下

### 调试接口

  可以使用Postman 调试接口

### 编写接口文档

  文档在docs目录中编写，如有多语言支持，按照[语言](https://zh.wikipedia.org/wiki/ISO_639-1%E4%BB%A3%E7%A0%81%E8%A1%A8)+[国家代码](https://zh.wikipedia.org/zh-hans/ISO_3166-1)进行分类
  如果内容较多，可拆分目录和文件，首页(README.md)只写简介和目录, 具体文档写在其他文件中, 使用markdown格式
  文档编写请参考 **接口编写规范**, 参考示例, 见[RESTful接口规范](https://zacksleo.github.io/2017/03/07/RESTful%E6%8E%A5%E5%8F%A3%E8%A7%84%E8%8C%83/)

### 格式检查

  每次代码提交会自动进行PSR-2标准的格式检查, 同时也可以在本地提前进行格式审查

  执行以下命令进行本地检查

  ```
   php vendor/bin/phpcs --standard=PSR2 --ignore=vendor/,packages/,console/migrations/,common/helpers -w --colors ./

  ```

  ### 单元测试

#### 1. 单元测试使用codeception框架进行测试

#### 2. 在`tests/unit`目录下编写单元测试用例

#### 3. 运行测试:

+ 首先进入容器 `docker exec -it yii2appadvanced_web_1 /bin/sh`
+ 在项目根目录下, 运行` ./vendor/bin/codecept run unit -c tests` 进行单元测试

### API测试

###  1. API测试使用codeception框架进行测试

#### 2. 在`tests/api` 目录下编写单元测试用例

#### 3. 运行测试:

+ 首先进入容器 `docker exec -it yii2appadvanced_web_1 /bin/sh`
+ 启动API服务 `php -S localhost:8080 --docroot api/tests &>/dev/null&`
+ 在项目根目录下, 运行`./vendor/bin/codecept run api -c tests`进行API测试

![](http://ww1.sinaimg.cn/large/675eb504gy1ffykpcylkvj20to09vab6.jpg)

  编写`.gitlab-ci.yml`文件, 配置持续集成, 本例中的持续集成分为以下几个阶段:

### 准备: 主要是依赖管理和安装

  通过定义的`composer.lock`安装项目所需要的依赖包

### 测试: 包括代码审查, 单元测试, API测试

  通过`phpcs` 来进行PSR-2规范的代码审查

### 构建: 包括Docker镜像的构建, 或者安装包的生成

  通过根目录下定义的`Dockerfile`来将整个项目打包成镜像(包含vendor目录), 打包成功后发布到Docker私有库中, 以便下一步的部署

### 部署: 包括实现远程自动部署及更新

  通过在`deploy`目录下`docker-compose.yml`中的编排, 拉取私有库中的镜像, 进行部署

  >注意， deploy 目录中的 docker-compose.yml, 需要修改web镜像

#### 部署流程

+ 默认情况下，项目有develop和master两个分支，当代码合并到develop分支时，会自动部署到测试环境；
+ 当合并到master时，会自动部署到预演环境；
+ 打完tag标签, 会自动生成正式环境的镜像，然后在 Piplines 处，点击一下手动部署按钮，会自动部署到正式环境

## 更多

### 自动化

   + [GitLab-CI 持续集成](https://zacksleo.github.io/tags/GitLab-CI/)

### 规范

   + [PHP编码规范](https://zacksleo.github.io/2017/03/07/PHP%E7%BC%96%E7%A0%81%E8%A7%84%E8%8C%83/)
   + [Git工作流程及使用规范](https://zacksleo.github.io/2017/03/07/Git%E5%B7%A5%E4%BD%9C%E6%B5%81%E7%A8%8B%E5%8F%8A%E4%BD%BF%E7%94%A8%E8%A7%84%E8%8C%83/)
   + [RESTful接口规范](https://zacksleo.github.io/2017/03/07/RESTful%E6%8E%A5%E5%8F%A3%E8%A7%84%E8%8C%83/)
   + [接口文档编写规范](https://apiblueprint.org/)
   + [中文文案排版指北](https://mazhuang.org/wiki/chinese-copywriting-guidelines/)
   + [CSS编码规范](http://iischajn.github.io/trans/htmlcss-guide/)
   + [JavaScript编码规范](https://zacksleo.github.io/2017/03/07/JavaScript%E7%BC%96%E7%A0%81%E8%A7%84%E8%8C%83/)

### 相关文档

  + [Yii2官方文档](https://www.yiiframework.com/doc/guide/2.0/zh-cn)
  + [PHP7官方文档](http://php.net/manual/zh/migration70.new-features.php)
  + [Composer中文文档](https://docs.phpcomposer.com/)
  + [Docker官方中文文档](https://docs.docker-cn.com/)
  + [docker-compose官方文档](https://docs.docker-cn.com/compose/)
  + [phpunit官方中文文档](https://phpunit.de/manual/current/zh_cn/index.html)
  + [GitLab-CI官方文档](https://docs.gitlab.com/ee/ci/)
  + [理解RESTful](http://www.ruanyifeng.com/blog/2011/09/restful.html)
  + [Codeception官方文档](https://codeception.com/docs/01-Introduction)