<?php

namespace leruge\facade;

use think\Facade;

/**
 * @title 权限类的门面
 * @author Leruge
 * @email leruge@163.com
 *
 * @method bool check($name, $uid, $relation = 'and') static 验证是否有权限
 * @method array authList($uid) static 权限名称数组，不区分上下级
 * @method array userRuleIdList($uid) static 权限ID数组
 */
class Auth extends Facade
{
    protected static function getFacadeClass()
    {
        return \leruge\Auth::class;
    }
}