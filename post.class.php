<?php 
    include __DIR__ . "./db.class.php";

    class Posts extends Database{

        public string $url = "http://localhost/homework4-grup-3/";

        public function index(){

            $str = "SELECT * FROM posts";
            $data = $this->connect()->query($str);

            return $data->fetchAll(PDO::FETCH_ASSOC);

        }

        public function Limit($id = null){
            $str = "SELECT * FROM posts WHERE id = ?";
            $data = $this->connect()->prepare($str);
            $data->execute([$id]);

            return $data->fetchAll(PDO::FETCH_ASSOC);  //fetch_assoc; veritabanı tablosundaki verileri isimleri ile getirir

        }

        public function Update($name, $content, $up_at, $id){

            $str = "UPDATE posts SET name = ?, content = ?, update_at = ? WHERE id = ?";
            $data = $this->connect()->prepare($str);
            $data->execute([
                $name,
                $content,
                $up_at,
                $id,
            ]);

            
            

        }
        public function Delete($id){
            $str = "DELETE FROM posts where id = ?";
            $data = $this->connect()->prepare($str);
            $data->execute([
                $id,
            ]);
            
        }

        public function addPost($image, $name, $content, $cre_at){


            $imageName  = $image['name'];
            $type       = $image['type'];
            $tmp_name   = $image['tmp_name'];
            $error      = $image['error'];
            $size       = $image['size'];

           $dizin="../config/images/";
           $hedef=$dizin.basename($imageName);



           if(move_uploaded_file($tmp_name,$hedef)):

                $str  = "INSERT INTO posts (image, name, content, created_at) VALUES (?, ?, ?, ?)";

                $data = $this->connect()->prepare($str);
                $data->execute([
                    $imageName,
                    $name,
                    $content,
                    $cre_at,
                ]);
            
           endif;

    
       

        }


    }

    $Posts = new Posts();
    