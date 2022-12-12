<?php 

class TaskDetail {
    public function TaskDetail() {
        $imgPath = "original/" . $this->profilepicture;

        $dateFrom = date("d/m - H:i", strtotime($this->datefrom));
        $dateTo = date("d/m - H:i", strtotime($this->dateto));

        $response = "<div class='detail-card'>";
        $response .= "<h2>Giver <b class='detail-procent'>" . $this->earnings ."%</b> udbtte</h2>";
        $response .= "<p class='detail-subheader'>ved afhentning af pant</p>";
        $response .= "<div class='afhentningsdetaljer'><div><p class='dato-detail'>Afhentning</p><br>";
        $response .= "<div class='date-detail'><p class='detail-info'><b class='fed'>Fra</b> " . $dateFrom . "</p>";
        $response .= "<p class='detail-info'><b class='fed'>Til</b> " . $dateTo . "</p></div>";
        $response .= "<p class='dato-detail'>Adresse</p><br>";
        $response .= "<div class='date-detail'><p class='detail-info'>" . $this->adress . "</p>";
        $response .= "<p class='detail-info'>" . $this->zipcode . " " . $this->city . "</p></div></div>";
        $response .=  "<div class='quantity-box-detail'><div class='amount-detail'>" . $this->bags . "<p>x</p><img class='taskicons' src='img/poseikon.png'></img></div>";
        $response .=  "<div class='amount-detail'>" . $this->sacks . "<p>x</p><img class='taskicons' src='img/bagikon.png'></img></div>";
        $response .=  "<div class='amount-detail'>" . $this->crates . "<p>x</p><img class='taskicons detail-icons-kasse' src='img/kasseikon.png'></img></div></div></div><div class='creator-info'>";
        $response .= "<a href='other-profile.php?id=" . $this->creatorid . "'>";
        if($this->profilepicture == NULL){
            $response .= "<img class='taskPics' src='img/dummy.jpg'></img>";
        } else {
            $response .= "<img class='taskPics' src='$imgPath'></img>";
        }
        $response .= "</a><h4>" . $this->firstname . "</h4></div>";
        if($this->note == ''){
            $response .= "<p><i>Der er ingen note.</i></p></div>";
        } else {
            $response .= "<p><i>''" . $this->note . "''</i></p></div>";
        }
        
        
        return $response;
        }  
}

?>