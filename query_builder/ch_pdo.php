<?php
class DatabaseClass{
    private $sql_stmt="";
    private $join="";
    private $pdo;
    function __construct($dsn,$username,$password)
    {
        $this->pdo=new PDO($dsn,$username,$password);
        
    }
    public function query_build(){
        if($this->sql_stmt!=""){
           $stmt=$this->pdo->prepare($this->sql_stmt.' '.$this->join);
           $stmt->execute(); 
           return $stmt->fetchAll(PDO::FETCH_OBJ);
       }
      
    }

   public function query($table,$sl_list=null,$where=null){
        if($sl_list!=null){
                 
            $query_list=implode(",",$sl_list);
        }
        if($sl_list==null && $where==null){
            $this->sql_stmt="select*from $table";
            return $this;
        }
       else if($sl_list==null && $where!= null){
           $this->sql_stmt="select * from $table where $where";
           return $this;
      
       }
       else if($where==null){
        $this->sql_stmt="select $query_list from $table ";
        return $this;
       }
       else{
            $this->sql_stmt="select $query_list from $table where $where";
            return $this;
       }
       
    }
    public function join($table_Stmt,$type="inner",$condition=null){
        $join_types=array("left","outer","right","inner");
        if(in_array(strtolower($type),$join_types)){
             $this->join.='  '.$type.' join '.$table_Stmt.' '.$condition;
            }
           return $this;
        
    }
  
    public function groupby($table_Stmt,$type="inner",$condition=null){
        $join_types=array("left","outer","right","inner");
        if(in_array(strtolower($type),$join_types)){
             $this->join.='  '.$type.' join '.$table_Stmt.' '.$condition;
            }
           return $this;
        
    }
   








    }

$database="e-commerce";
$dsn="mysql:host=localhost;dbname=$database;charset=utf8mb4";
$username="root";
$password="";
$db_obj=new DatabaseClass($dsn,$username,$password);

// $result=$db_obj->query("category",);
// $count=$db_obj->add("category","radioes");
// echo $count."<br>";
// $count=$db_obj->delete("category","name","radioes");
// echo $count."<br>";
// $count=$db_obj->update("category","active","1","name='phones' and id='3'");
// echo $count."<br>";
// $result=$db_obj->query("category",array("id","name","active"));
// foreach($result as $row)
// {
//     echo "id  ".$row->id." name  ".$row->name." active  ".$row->active."<br>";
// }

// $sl_list= array("id","name","active");
// $query_list=implode(",",$sl_list);
// $table="cate";
// echo "select $query_list from $table";
// $result=$db_obj->query("category",array("id","name"),"name='phones' and id='3'");
$update_data = array(  
    'name'     =>  "rel"  ,  
    'active'   =>   1 
);  
$where_condition = array(  
    'id'     =>    7  
);  

$result=$db_obj->query("category")->join("products "," inner "," on category.id = 3")->query_build();//.join("products")

   $insert_data = array(  
           'id'     =>    null,  
           'name'          => "lapppms" ,
           'active'   => "0" 
      );

foreach($result as $row)
 {
  
     echo "id  ".$row->id." name  ".$row->name." active  ".$row->active."<br>";

}


?>