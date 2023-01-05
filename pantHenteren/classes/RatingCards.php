<?php 

class RatingCards {
    public function RatingCard() {
        $imgPath = "original/" . $this->profilepicture;

        $response = "<div class='reviewCardDiv'><div class='index-task-cards'><div class='taskTop'><div class='topdiv'>";
        if($this->profilepicture == NULL){
            $response .= "<img class='taskPics' src='img/dummy.jpg'></img>";
        } else {
            $response .= "<img class='taskPics' src='$imgPath'></img>";
        }
        $response .= "<h4>" . $this->firstname . "</h4>";
        $response .= "<h5>| " . $this->rating . "</h5> <span class='fa fa-star icon fa-star-ratingCard'></span>";
        if($this->creatorid == $_SESSION['login']){
            $response .= "<button class='delete-review-btn delete-review-btn-ratingCards' onclick='togglePopupDeleteReview(); return false'></button>";
        }
        $response .= "</div></div><div class='taskBottom'><div class='review-text-kasse'><p class='review-p'>" . $this->review . "</p>";
        $response .= "</div></div></div></div>";
        return $response;
        }  
}

?>