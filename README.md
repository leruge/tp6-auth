## tp6-auth
在thinkphp6.0上使用的auth扩展

### 安装
> composer require leruge/tp6-auth

### 权限配置
会自动在config配置目录创建auth.php配置文件，如果没有，请手动创建，配置参数如下
```
return [
    'auth_on'           =>  true,               // 认证开关
    'super_id_array'         => [],             // 拥有所有权限的用户，如[1, 2, 3]，那么这三个用户则拥有所有权限
];
```

### 生成数据库迁移文件和模型
```
php think auth:publish
```
这将自动生成3个模型文件和1个数据库迁移文件

### 执行迁移
```
php think migrate:run
```
这将创建auth_rule、auth_grop、auth_group_access3张表

### 用法
1. 实例化一个\leruge\Auth类
1. 或者使用它的门面\leruge\facade\Auth
1. 提供了3个方法check、authList、userRuleIdList

#### check方法
```
check($name, $uid, $relation)
$name 验证的权限，字符串是单条权限，多条权限使用数组
$uid 验证用户ID
$relation or满足一条则通过；and全部满足才能通过
```

#### authList方法
```
authList($uid)
返回权限列表，不区分上下级
```


#### userRuleIdList方法
```
userRuleIdList($uid)
返回权限ID数组
```
