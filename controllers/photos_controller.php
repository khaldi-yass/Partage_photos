<?php
  class PhotosController 
  {

    public function ajout_photo()
    {
      
      if (isset($_POST['submit_addphoto']))
      {

        try
        {

          $result = Photo::create($_POST, $_FILES);
          $tags = explode(",", $_POST['tags']);
          foreach ($tags as $tag) 
          {
              $cat = array('name' => $tag, 'description' => 'None');
              $result_tag = Category::create($cat);
          }
          $_SESSION['success'] = "Photo ajoute avec succes";
          $this->mes_photos();

        }
        catch (Exception $e)
        {

          $_SESSION['error'] = $e->getMessage();
          require_once('../public/views/elements/navbar.php');
          require_once('views/pages/home.php'); 

        }
      }
    }


    public function mes_photos() {

      try
      {
        $userInstance = User::find($_SESSION['user']['username']);
        $images = $userInstance->photos();
        require_once('../public/views/elements/navbar.php');
        require_once('views/photos/mes_photos.php');
      }
      catch(Exception $e)
      {
        $_SESSION['error'] = $e->getMessage();
        require_once('../public/views/elements/navbar.php');
        require_once('views/pages/home.php'); 
      }

    }

    public function affiche_photo() 
    {
      if(!empty($_GET['id']))
      {
        try
        {
          $photo = Photo::find($_GET['id']);
          $comments = $photo->comments();
          require_once('../public/views/elements/navbar.php');
          require_once('views/photos/affiche_photo.php'); 
        }
        catch (Exception $e)
        {
          $_SESSION['error'] = $e->getMessage();
          require_once('../public/views/elements/navbar.php');
          require_once('views/pages/home.php'); 
        }
      }
      else
      {
        $_SESSION['error'] = 'Veillez indiquer un id de photo valide!';
        require_once('../public/views/elements/navbar.php');
        require_once('views/pages/home.php');
      }

    }


    public function modif_photo() 
    {
      try
      {
          if (isset($_POST['submit_modif']))
          {
              $id = test_input($_POST['photo_id']);
              $title = test_input($_POST['title']);
              $date = test_input($_POST['date']);
              $desc = test_input($_POST['desc']);

              $photo = Photo::find($id);

              $photo->update_title($title);
              $photo->update_date($date);
              $photo->update_description($desc);

              $_SESSION['success'] = "Champs modifies avec succes";
              require_once('pages_controller.php');
              $pages = new PagesController();
              $pages->home();        
          }
          else
          {
            $photo = Photo::find($_GET['id']);
            require_once('../public/views/elements/navbar.php');
            require_once('views/photos/modif_photo.php');   
          }
      }
      catch (Exception $e)
      {
          $_SESSION['error'] = $e->getMessage();
          require_once('../public/views/elements/navbar.php');
          require_once('views/pages/home.php'); 
      }
    }

    public function cherche_photo()
    {
      try
      {
        if(isset($_POST['submit_recherche']))
        {
          $mot_cle = test_input($_POST['mot_cle']);
          $images = Photo::search($mot_cle);
          require_once('../public/views/elements/navbar.php');
          require_once('views/photos/recherche.php'); 
        }

      }
      catch (Exception $e)
      {
        $_SESSION['error'] = $e->getMessage();
        require_once('../public/views/elements/navbar.php');
        require_once('views/pages/home.php'); 
      }
    }

  }
?>

