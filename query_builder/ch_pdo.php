<?php
class DatabaseClass{
    private $sql_stmt="";
    private $join="";
    private $where="";
    private $groupby="";
    private $orderby="";
    private $limit="";
    private $counter=1;




    private $pdo;
    function __construct($dsn,$username,$password)
    {
        $this->pdo=new PDO($dsn,$username,$password);
        
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
  
    public function orderby($sort=null){
       if($sort!=null){
           echo "not null";
           foreach($sort as $key =>$value ){
                if(is_int($key)&&(count($sort)==1)){
                    echo "indexed";
                        $this->orderby.=' '.'order by '.''.$value.' ' .'asc'.' , ' ;
                        echo ' '.'order by '.''.$value.' ' .'desc'.' , ';
                }
                else{
                    $this->orderby.=' '.'order by '.''.$key.' ' .$value.' , ' ;
                    echo ' '.'order by '.''.$key.' ' .$value.' , ';
                }
           }
           $this->orderby = substr( $this->orderby, 0, -2);  
     
       }
           return $this;
        
    }
    public function groupby($group_cols=null){
        if($group_cols!=null){
            $groupString=implode(',',$group_cols);
            $this->groupby.=' '.'group by'.' '. $groupString;
            echo ' '.'group by'.' '. $groupString;
        }

        return $this;
    }
    public function limit($limit_params=null){
        if($limit_params!=null){
            $limit_string=implode(',',$limit_params);
            $this->limit.=' '.'limit'.' '. $limit_string;
            echo ' '.' limit '.' '. $limit_string;
        }

        return $this;
    }
    
    public function where($where_con_1,$link=null,$where_con_2=null){
        $def_link='and';
        $link_arr=array('and','or');
        if(in_array(strtolower($link),$link_arr)||$link==null){
            echo 'link is null';
            if($this->counter>1){
                $this->where.='  '. $def_link.' '.$where_con_1.' '.$link.'  '.$where_con_2;
                echo 'counter>1';
            }
            else{
                echo 'counter<1';
                $this->where.='  '.'where'.' '.$where_con_1.' '.$link.' '.$where_con_2;
                echo '  '.'where'.' '.$where_con_1.' '.$link.' '.$where_con_2;
            }
        $this->counter++;
      }
      return $this;
    }
  

    public function query_build(){
        if($this->sql_stmt!=""){
           $stmt=$this->pdo->prepare($this->sql_stmt.' '.$this->join.' '.$this->where.' '.$this->groupby.' '.$this->orderby.' '.$this->limit);
           $stmt->execute(); 
           return $stmt->fetchAll(PDO::FETCH_OBJ);
       }
      
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

// $result=$db_obj->query("category")->join("products "," inner "," on category.id = 3")->query_build();//.join("products")
// $result=$db_obj->query("products")->orderby(array('id'=>'desc'))->query_build();
// $result=$db_obj->query("products")->orderby(array('name'))->query_build();
// $result=$db_obj->query("products")->groupby(array('active'))->orderby(array('name'))->query_build();
// $result=$db_obj->query("products",array("count(id) as count"))->orderby(array('name'))->query_build();
// $result=$db_obj->query("products")->limit(array('2','1'))->query_build();
$result=$db_obj->query("products")->where('id = 64','or','name = "nokia"')->query_build();








   $insert_data = array(  
           'id'     =>    null,  
           'name'          => "lapppms" ,
           'active'   => "0" 
      );

foreach($result as $row)
 {
  
     echo "<br>"."id  ".$row->id." name  ".$row->name." active  ".$row->active."<br>";
    //  echo $row->count."<br>";


}


?>