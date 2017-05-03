# 项目名称

> 该项目用于快速搭建API服务端及后台框架

> 内置持续集成, 实现了自动化代码审查、composer包依赖自动构建、自动化测试、Docker镜像打包和发布

## 开始

### 创建项目

#### 方法
 
+ 在GitLab上点击创建项目
+ 在 Import project from 中, 点击 Repo By URL
+ 输入要导入的地址: `git@github.com:zacksleo/yii2-app-advanced.git`,(将username和password替换为自己的用户名和密码)
+ 点击创建


### 安装依赖库

  使用 `composer install` 安装所需要的依赖库
  
### 使用Docker创建运行环境

  使用 docker-compose 创建运行环境:
  
  ```
   docker-compose up 
   
  ```

### 修改环境变量

  修改 docker-compose.yml中 nginx 和 db 暴露的接口, 如
  
  ```
      nginx:
          build: ./services/nginx
          ports:
              - "80:80"
          links:
              - web
          volumes_from:
              - web
  
      db:
          image: mysql:5.6
          ports:
              - "3306:3306"
  ```
  
  > 注意, 开发环境中, 可以暴露数据库接口到外网, 如果是正式环境,请关闭端口
  
  修改 service/nginx/nginx.conf 中监听的端口, 使之与docker-compose.yml中的对应: 如`listen 886 ssl;``
  
  
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

### 调试接口
  
  可以使用Postman 调试接口
  
### 编写接口文档
  
  点击项目右侧的`Wiki`, 开始编写文档, 首页(Home)只写简介和目录, 具体文档写在其他文件中, 使用markdown格式,
  文档编写请参考 **接口编写规范**, 参考示例, 见[RESTful接口规范](https://zacksleo.github.io/2017/03/07/RESTful%E6%8E%A5%E5%8F%A3%E8%A7%84%E8%8C%83/)

### 格式检查

  每次代码提交会自动进行PSR-2标准的格式检查, 同时也可以在本地提前进行格式审查
  
  执行以下命令进行本地检查
  
  ```
   php vendor/bin/phpcs --standard=PSR2 --ignore=vendor/,packages/,console/migrations/,common/helpers -w --colors ./
   
  ```
  
### 持续集成 
  
  ![](http://ww1.sinaimg.cn/large/675eb504gy1fesezaolfyj20w30axdh2.jpg)
  
  编写`.gitlab-ci.yml`文件, 配置持续集成, 本例中的持续集成分为以下几个阶段:
  
  + 准备: 主要是依赖管理和安装
  + 测试: 包括代码审查, 单元测试, 功能测试和验收测试 
  + 构建: 包括Docker镜像的构建, 或者安装包的生成
  + 部署: 包括实现远程自动部署及更新
   