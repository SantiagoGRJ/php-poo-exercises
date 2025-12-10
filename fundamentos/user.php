<?php 

class User {

    private string $name;
    private string $email;

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name=$name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email=$email;
    }

}

$user=new User();
$user->setName("Santiago");
$user->setEmail("santiago@gmail.com");
if(substr($user->getEmail(),-4) !==".com"){
    echo "Email invalid";
    return;
}
echo $user->getEmail();

?>
