<?php
    require "database.php";
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();
    //INCLUDE DATABASE FILE
    //ROUTING
    if(isset($_POST['save']))        saveTask();
    if(isset($_POST['update']))      updateTask();
    if(isset($_GET['id']))           deleteTask();


    
    function getTasks($status)
    {
        
        //CODE HERE
        $requete = "SELECT * FROM tasks";
        $counter=1;
        global $conn;
        $query=mysqli_query($conn,$requete);
        // print_r($query);
        while($rows=mysqli_fetch_assoc($query)){
        
       

        if($rows['status_id']==$status){
            if($status==1){
                $icons='fa fa-question circle text-red';
            }
            if($status==2){
                $icons='fa fa-clock text-orange';
            }
            if($status==3){
                $icons='fa fa-check circle';
            }
        
            $priority=$rows['priority_id']==1?'Low':($rows['priority_id']==2?'Medium':($rows['priority_id']==3?'High':'Critical'));
        $type=$rows['type_id']==1?'Feature':'Bug';
        $id=$rows['id'];
        echo '<div class="bg-white w-100 border-0 border-top d-flex py-2 task_edit" id="'.$id.'" title="'.$rows['title'].'
                   " description="'.$rows['description'].'" status="'.$rows['status_id'].'" date="'.$rows['task_datetime'].'" 
                   priority="'.$rows['priority_id'].'" data-type="'.$rows['type_id'].'">

                <div class="px-2">
                <div class="text-green fs-4 px-2">
                <i class="'.$icons.'"></i> 
            </div>
                </div>
                <div class="text-start">
                    <div class="h6 d-none id_tasks">'.$rows['id'].'</div>
                    <div class="h6 d-none">'.$rows['status_id'].'</div>
                    <div class="h6">'.$rows['title'].'</div>
                    <div class="text-start">
                        <div class="text-gray"> #'.$counter++.'  '.$rows['task_datetime'].'</div>
                        <div title='.$rows['description'].'"class="text-truncate description" style="max-width: 16rem;">'.$rows['description'].'</div>
                    </div>
                    <div class="my-10px">
                        <span class="bg-blue-500 p-5px px-10px text-white rounded-2">'.$priority.'</span>
                        <span class="bg-gray-400 p-5px px-10px text-black rounded-2">'.$type.'</span>
                        <a href="scripts.php?id='.$rows["id"].' "class="bg-red-500 p-5px px-10px text-white rounded-2">delete</a>
                        <a href="#modal-task" data-bs-toggle="modal" onclick="editdTask('.$id.')" class="bg-cyan-500 p-5px px-10px text-white rounded-2 btn-edit">edit</a>
                    </div>
                </div>
            </div>';
        }
}
        //SQL SELECT
    }
    
         

 
function saveTask() 
    {
        // CODE HERE
        
        $title = $_POST['title'];
        $tasktype = $_POST['tasktype'];
        $priority = $_POST['priority'];
        $status = $_POST['status'];
        $date = $_POST['date'];
        $description = $_POST['description']; 
        // echo $tasktype;
        //SQL INSERT

        $requete="INSERT INTO tasks(`title`, `type_id`, `priority_id`, `status_id`, `task_datetime`, `description`) 
        
        VALUES ('$title','$tasktype','$priority','$status',' $date','$description')";

        global $conn;
        mysqli_query($conn,$requete);

        // print_r($_POST);
        $_SESSION['message'] = "Task has been added successfully !";
		header('location: index.php');
    }

    function updateTask()
    {
        // var_dump(($_POST));
        
        $update=$_POST['task-id'];
        $title = $_POST['title'];
        $tasktype = $_POST['tasktype'];
        $priority = $_POST['priority'];
        $status = $_POST['status'];
        $date = $_POST['date'];
        $description = $_POST['description']; 
        echo $tasktype;

        // SQL UPDATE

        $requete="UPDATE `tasks` SET `title`='$title',`type_id`='$tasktype',`priority_id`='$priority',`status_id`='$status',`task_datetime`='$date',`description`='$description' WHERE id=$update";
        
        global $conn;
        mysqli_query($conn,$requete);

        $_SESSION['message'] = "Task has been updated successfully !";
		header('location: index.php');
    }

    function deleteTask()
    {
        //CODE HERE
       global $id,$conn;
       $id=$_GET['id'];
       $requete= "DELETE FROM tasks WHERE id='$id'";
       $query=mysqli_query($conn,$requete);
       if(isset($query))
        //SQL DELETE
        $_SESSION['message'] = "Task has been deleted successfully !";
		header('location: index.php');
    }

?>