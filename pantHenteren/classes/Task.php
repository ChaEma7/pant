<?php 

class Task {
    public function TaskCard() {
        $imgPath = "original/" . $this->profilepicture;

        $response = "<a class='cardTasks' href='task-detail.php?id=$this->id'><div class='task-cards'><div class='taskTop'>";
        if($this->profilepicture == NULL){
            $response .= "<img class='taskPics' src='img/dummy.jpg'></img>";
        } else {
            $response .= "<img class='taskPics' src='$imgPath'></img>";
        }
        $response .= "<div class='topdiv' ><h4>" . $this->firstname . "</h4>";
        $response .= "<h5>| " . $this->city . "</h5></div> ";
        $response .= "<p class='udbytte-card'>" . $this->earnings . " %</p></div>";
        $response .= "<div class='taskBottom'><div><p class='dato-card'>Afhentning</p><br>";
        $response .= "<p class='dato'>Fra " . $this->datefrom . "</p>";
        $response .= "<p class='dato'>Til " . $this->dateto . "</p></div><div class='quantity-box-card'>";
        $response .=  $this->bags . "<div class='amount-card'><p>x</p><img class='taskicons' src='img/poseikon.png'></img></div>";
        $response .=  $this->bags . "<div class='amount-card'><p>x</p><img class='taskicons' src='img/bagikon.png'></img></div>";
        $response .=  $this->bags . "<div class='amount-card'><p>x</p><img class='taskicons' src='img/kasseikon.png'></img></div></div></div></a>";
        return $response;
        }  
}

?>