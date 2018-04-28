<?php
class getsmscode {
    private $username = '';
    private $token = '';
    private $endpoint1 = 'http://www.getsmscode.com/do.php?';
    private $endpoint2 = 'http://www.getsmscode.com/vndo.php?';
    
    private function req(array $args, $endpoint) {
        if(!in_array($endpoint, [1, 2])) {
            throw new Exception('Endpoint must be 1 or 2.');
        }
        if($endpoint == 1) {
            return file_get_contents($this->endpoint1.http_build_query($args));
        }elseif($endpoint == 2) {
            return file_get_contents($this->endpoint2.http_build_query($args));
        }
    }
    
    public function __construct($username, $token) {
        $res = $this->req(['action' => 'login', 'username' => $username, 'token' => $token], 1);
        if($res == 'username is wrong') {
            throw new Exception($res);
        }elseif($res == 'token is wrong') {
            throw new Exception($res);
        }else{
            $this->username = $username;
            $this->token = $token;
            return true;
        }
    }
    
    public function get_balance() {
        $req = $this->req(['action' => 'login', 'username' => $this->username, 'token' => $this->token], 1);
        $args = explode('|', $req);
        if(!isset($args[1])) {
            throw new Exception($req);
        }
        return $args[1];
    }
    
    public function get_number($pid, $cocode) {
        if($cocode == 'cn') {
            $req = $this->req(['action' => 'getmobile', 'username' => $this->username, 'token' => $this->token, 'pid' => $pid], 1);
        }else{
            $req = $this->req(['action' => 'getmobile', 'username' => $this->username, 'token' => $this->token, 'pid' => $pid, 'cocode' => $cocode], 2);
        }
        if(is_numeric($req)) {
            return $req;
        }
        throw new Exception($req);
    }
    
    public function get_sms($number, $pid, $cocode) {
        if($cocode == 'cn') {
            $req = $this->req(['action' => 'getsms', 'username' => $this->username, 'token' => $this->token, 'pid' => $pid, 'mobile' => $number, 'author' => $this->username], 1);
        }else{
            $req = $this->req(['action' => 'getsms', 'username' => $this->username, 'token' => $this->token, 'pid' => $pid, 'mobile' => $number, 'cocode' => $cocode], 2);
        }
        if(strpos($req, '1|') === 0) {
            return str_replace('1|', '', $req);
        }
        return false;
    }
    
    public function add_blacklist($number, $pid, $cocode) {
        if($cocode == 'cn') {
            $req = $this->req(['action' => 'addblack', 'username' => $this->username, 'token' => $this->token, 'pid' => $pid, 'mobile' => $number], 1);
        }else{
            $req = $this->req(['action' => 'addblack', 'username' => $this->username, 'token' => $this->token, 'pid' => $pid, 'mobile' => $number, 'cocode' => $cocode], 2);
        }
        if($req == 'Message|Had add black list') {
            return true;
        }
        return false;
    }
    
}
