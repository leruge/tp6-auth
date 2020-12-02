<?php
/**
 * @title thinkphp5.1权限认证类
 * @author Leruge
 * @email leruge@163.com
 */
namespace leruge;

class Auth
{
    protected $config = [
        'auth_on'           =>  true,                // 认证开关
        'super_id_array'         => [],                   // 拥有所有权限的用户，如[1, 2, 3]，那么这三个用户则拥有所有权限
    ];

    // 权限组模型
    public $authGroup = null;

    // 用户-用户组关系模型
    public $authGroupAccess = null;

    // 规则模型
    public $authRule = null;

    public function __construct()
    {
        if (config('auth')) {
            $this->config = array_merge($this->config, config('auth'));
        }
        $this->authGroup = '\\app\\model\\' . parse_name($this->config['auth_group'], 1);
        $this->authGroupAccess = '\\app\\model\\' . parse_name($this->config['auth_group_access'], 1);
        $this->authRule = '\\app\\model\\' . parse_name($this->config['auth_rule'], 1);
    }

    /**
     * @title 检查权限
     *
     * @param string|array $name 验证的权限，字符串是单条权限，多条权限使用数组
     * @param integer $uid 验证用户ID
     * @param string $relation or满足一条则通过；and全部满足才能通过
     *
     * @return boolean 通过验证返回true，不通过返回false
     */
    public function check($name, $uid, $relation = 'and')
    {
        if (!$this->config['auth_on']) {
            return true;
        }

        if (in_array($uid, $this->config['super_id_array'])) {
            return true;
        }

        $authList = $this->authList($uid);

        // 用户需要校验的权限
        if (is_string($name)) {
            $name = [$name];
        }

        foreach ($name as $k1 => $v1) {
            $name[$k1] = strtolower($v1);
        }
        foreach ($authList as $k2 => $v2) {
            $authList[$k2] = strtolower($v2);
        }

        $diff = array_diff($name, $authList);
        $intersect = array_intersect($name, $authList);
        if ($relation == 'or' && $intersect) {
            return true;
        }
        if ($relation == 'and' && !$diff) {
            return true;
        }
        return false;
    }

    /**
     * @title 用户的权限列表
     *
     * @param integer $uid 用户ID
     *
     * @return array 权限规则列表
     */
    public function authList($uid)
    {
        // 获取用户权限ID数组
        $ruleIdArray = $this->userRuleIdList($uid);

        return (new $this->authRule)->where('id', 'in', $ruleIdArray)->column('name');
    }

    /**
     * @title 用户的权限ID列表
     *
     * @param integer $uid 用户ID
     *
     * @return array 权限ID列表
     */
    public function userRuleIdList($uid)
    {
        if (in_array($uid, $this->config['super_id_array'])) {
            $ruleIdArray = (new $this->authRule)->column('id');
        } else {
            $groupIdArray = (new $this->authGroupAccess)->where('uid', $uid)->column('group_id');
            $where[] = ['id', 'in', $groupIdArray];
            $rulesList = (new $this->authGroup)->where($where)->column('rules');
            $ruleIdArray = [];
            foreach ($rulesList as $k => $v) {
                $ruleIdArray = array_merge($ruleIdArray, explode(',', trim($v, ',')));
            }
            $ruleIdArray = array_unique($ruleIdArray);
            $ruleIdArray = array_filter($ruleIdArray);
            sort($ruleIdArray);
        }
        return $ruleIdArray;
    }
}