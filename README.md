Use Yaf && Charisma create a grid Scaffold

@author ciogao@gmail.com

Yaf(PHP扩展框架框架Yet Another Framework)

Yaf.Scaffold 免费、开源的脚手架工具.
在一次项目中，使用Yaf与Charisma搭建的脚手架工具，用于快速搭建项目的管理后台。现在向您分享了它，希望能为您的工作带来帮助。

当然，欢迎对这个项目感兴趣的童鞋，也加入这个项目！


### Yaf.Scaffold目前提供了什么
* 使用Yaf构建的清晰MVC框架
* 高效、可配置的DB\Cache访问类库
* 数据库字典 /Datatable/dic
* 简洁、优雅的RESTful服务构建lib
* 以自身Scaffold机制来管理的Scaffold

### Yaf.Scaffold可能的目标
* 更高效的DB\Cache访问
* 更方便的Scaffold
* 构建WorkFlow机制,控制数据流向
* 以Yaf.Scaffold为基础，快速搭建稳定、可靠、高效的CMS/OA/ERP/CRM…

### Scaffold需启用ReWriteEngine

#### Apache

```conf
#.htaccess
RewriteEngine On
RewriteCond $1 !^(index\.php|uploads|resources)
RewriteRule ^(.*)$ index.php/$1 [L]
```

#### Nginx

```
server {
  listen ****;
  server_name  YafScaffold.com;
  root   document_root;
  index  index.php index.html index.htm;

  if (!-e $request_filename) {
    rewrite ^/(.*)  /index.php/$1 last;
  }
}
```
