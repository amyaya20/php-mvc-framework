<?php



    namespace app\controllers;

use amohd12\phpmvc\Application;
use amohd12\phpmvc\Request;
use amohd12\phpmvc\Response;
use app\models\ContactForm;

    class SiteController extends \amohd12\phpmvc\Controller{


        
        public function home(){

            $params = [

                'name' => "TheCodeholic"


            ];

            return $this -> render('home',$params);
        }

        public function contact(Request $request, Response $response){ // we should include the parameters when we call the call_user_func

            $contact = new ContactForm();

            if($request-> isPost()){

                $contact-> loadData($request-> getBody());

                if($contact-> validate() && $contact-> send()){

                    Application::$app-> session-> setFlash('success', 'Thanks for contacting us.');

                    return $response-> redirect('/contact');
                }
            }

            return $this -> render('contact', [

                'model' => $contact
            ]);
        }

        
    }



