<?php
 
class payment {
 
    /*
 
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
   
    */
 
    public function __construct() {
 
        global $config;
 
        $this->config = $config;
        $this->up = $config['unitpay'];
 
    }
 
    /*
 
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
   
    */
 
    public function up_json_reply($type = 'error', $params) {
 
        if ($type == "check" || $type == "pay") $type = "success";
 
        $reply = [
 
            'error' => [
                'jsonrpc' => '2.0',
                'error' => [ 'code' => -32000, 'message' => 'Не-не, так не пойдёт' ],
                'id' => $params['projectId']
            ],
 
            'success' => [
                'jsonrpc' => '2.0',
                'result' => [ 'message' => 'Покупка завершена!' ],
                'id' => $params['projectId']
            ]
 
        ];
 
        return json_encode($reply[$type]);
 
    }
 
    /*
 
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
   
    */
   
    public function up_sign($method, $reply) {
 
        $usr = explode('-', $reply['account']);
 
        $sum = $reply['sum'];
        $Sign = $reply['signature'];
 
        $reply['projectId'] = $this->config['unitpay']['id'];
 
        if ($reply['signature'] != $this->getSha256Sign($method, $reply, $this->config['unitpay']['key']))
            return $this->up_json_reply();
 
        if($this->config['group'][$usr[1]]['surcharge']){
 
            $surcharge = $this->surcharge($usr[0]);
 
            if($surcharge)
                $sum = $surcharge + $sum;
           
        }
 
        $price = $this->config['group'][$usr[1]]['price'];
 
        if($price == 0 || !$price || $sum < $price)
            return $this->up_json_reply('error', $reply);
 
        return $this->up_json_reply('success', $reply);
 
    }
 
    /*
 
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
   
    */
 
    public function surcharge($name) {
 
        $db = mysqli_connect($this->config['db_host'], $this->config['db_user'], $this->config['db_pass'], $this->config['db_base']) or die('Ошибка подключения к БД, обновите страницу.');
 
        $uuid = $db->query("SELECT `name` FROM `permissions` WHERE `value` = '".trim(strip_tags($name))."' AND `type` = '1'")->fetch_object();
        $group = $db->query("SELECT * FROM `permissions_inheritance` WHERE `child` = '".$uuid->name."' ORDER BY `id` DESC LIMIT 1")->fetch_object();
 
        if(!$group)
            return false;
 
        return $this->config['group'][$group->parent]['price'];
    }
 
    /*
 
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
   
    */
   
    public function pay_form($amount, $user, $gid) {
 
        $desc = "Покупка игровой привилегии для игрока: {$user}";
        return "https://unitpay.ru/pay/{$this->up['project_id']}?sum={$amount}&account={$user}-{$gid}&desc={$desc}";
 
    }
 
    /*
 
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
   
    */
   
    public function pay($amount, $user) {
 
        $ex = explode ( '-', $user );
        $gid = $this->config['group'][$ex[1]];
 
        $cmd = str_replace( ['<group>', '<user>'], [$ex[1], $ex[0]], $gid['cmd'] );
 
            $out = file_get_contents('log.txt');
            file_put_contents('log.txt', $log.$cmd.' ('.$ex[1].')'."\n");
 
        return $this->give($cmd);
 
    }
 
    /*
 
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
   
    */
 
    private function getMd5Sign($params, $secretKey)
    {
        ksort($params);
        unset($params['sign']);
        return md5(join(null, $params).$secretKey);
    }
 
    /*
 
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
        НЕ УДАЛЯТЬ КОММЕНТАРИЙ
   
    */
 
    private function getSha256Sign($method, array $params, $secretKey)
    {
        $delimiter = '{up}';
        ksort($params);
        unset($params['sign']);
        unset($params['signature']);
        return hash('sha256', $method.$delimiter.join($delimiter, $params).$delimiter.$secretKey);
    }

    private function give($cmd) {
        include 'rcon.class.php';
        $rcon = new Rcon($this->config['ip_server'], $this->config['port_server'], $this->config['rcon_pass'], 5);

        if(@$rcon->connect())
            @$rcon->send_command($cmd);
        else 
            return $this->give($cmd);

        return 'Донат успешно выдан!';
    }
 
}
 
?>
