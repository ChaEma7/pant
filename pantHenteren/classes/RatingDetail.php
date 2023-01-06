<?php 

class RatingDetail {
    public function Reviews() {
        $imgPath = "original/" . $this->profilepicture;

        $response = "<section class='reviewBox'>";
        $response .= "<div class='reviewTop'>";
        $response .= "<a href='other-profile.php?id=" . $this->creatorid . "'>";
        if($this->profilepicture == NULL){
            $response .= "<img class='taskPics' src='img/dummy.jpg'></img>";
        } else {
            $response .= "<img class='taskPics' src='$imgPath'></img>";
        }
        $response .= "</a><div class='reviewInfo'>";
        $response .= "<h4>" . $this->firstname . "</h4><div class='reviewStjerner'>";
        if($this->rating == '1'){
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/tomstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/tomstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/tomstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/tomstjerne-ikon.png'></img>";
        } else if($this->rating == '2') {
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/tomstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/tomstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/tomstjerne-ikon.png'></img>";
        } else if($this->rating == '3') {
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/tomstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/tomstjerne-ikon.png'></img>";
        } else if($this->rating == '4') {
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/tomstjerne-ikon.png'></img>";
        } else if($this->rating == '5') {
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
            $response .= "<img class='stjernePics' src='img/fyldtstjerne-ikon.png'></img>";
        }        
        $response .= "</div></div>";
        if($this->creatorid == $_SESSION['login']){
            $response .= "<button class='delete-review-btn delete-review-btn-overview' onclick='togglePopupDeleteReview(); return false'></button>";
        }
        $response .= "</div>";
        $response .= "<div class='reviewDetailText'>";
        $response .= "<p>" . $this->review . "</p>";
        $response .= "</div>";
        $response .= "</div>";
        $response .= "</section>";
        return $response;
        }  
}

?>