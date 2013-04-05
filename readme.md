#meSmart php

**当前meSmart正处于开发中，即将发布第一版**

##目录结构

	meSmart
		|
		|----- App 				// 项目文件所在文件夹
		|----- Docs 			// 文档
		|----- Install 			// 项目安装说明和相关文件
		|----- Public 			// 项目入口，该文件夹可以更改目录
		|----- Runtime 			// 项目临时文件
		|----- Vendor 			// 第三方库，由composer进行包管理，包括meSmart也属于第三方库
				|----- meSmart
				|----- 其他第三方库


##Public 目录下的关键文件

	Public
		|
		|----- index.php
		|----- constant.php
		|----- autoload.php 	// 该文件可能在开发完后放入meSmart内容
		|----- functions.php 	// 该文件可能在开发完后放入meSmart内容，该文件不设置命名空间
		|----- composer.json

##App 目录下的关键文件（完全独立分组模式）

	App
		|----- Home
				|----- Mapping.php
				|----- Controllers
				|----- Models
				|----- Libraries
				|----- Views
				|----- Configs
				|----- Language

##Contact

* mail: minowu@foxmail.com