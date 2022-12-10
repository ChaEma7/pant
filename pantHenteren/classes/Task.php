<?php 

class Task {
    public function TaskCard() {
        $imgPath = "original/" . $this->profilepicture;

        $dateFrom = date("d/m - H:i", strtotime($this->datefrom));
        $dateTo = date("d/m - H:i", strtotime($this->dateto));


        $response = "<a class='cardTasks' href='task-detail.php?id=$this->id'><div class='task-cards'><div class='taskTop'><div class='topdiv'>";
        if($this->profilepicture == NULL){
            $response .= "<img class='taskPics' src='img/dummy.jpg'></img>";
        } else {
            $response .= "<img class='taskPics' src='$imgPath'></img>";
        }
        $response .= "<h4>" . $this->firstname . "</h4>";
        $response .= "<h5>| " . $this->city . "</h5></div> ";
        $response .= "<p class='udbytte-card'>" . $this->earnings . " %</p></div>";
        $response .= "<div class='taskBottom'><div><p class='dato-card'>Afhentning</p><br>";
        $response .= "<div class='dates'><p class='dato'><b class='fed'>Fra</b> " . $dateFrom . "</p>";
        $response .= "<p class='dato'><b class='fed'>Til</b> " . $dateTo . "</p></div></div>";
        $response .=  "<div class='quantity-box-card'><div class='amount-card'><p>" . $this->bags . "</p><p>x</p><img class='taskicons' src='img/poseikon.png'></img></div>";
        $response .=  "<div class='amount-card'><p>" . $this->sacks . "</p><p>x</p><img class='taskicons' src='img/bagikon.png'></img></div>";
        $response .=  "<div class='amount-card'><p>" . $this->crates . "</p><p>x</p><img class='taskicons taskicons-kasse' src='img/kasseikon.png'></img></div></div></div></a>";
        return $response;
        }  
}

?>