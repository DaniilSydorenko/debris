<?php
/*******************************************************************************
 * Name: App -> Main
 * Version: 1.0
 * Author: Daniil Sydorenko (daniildeveloper@gmail.com)
 ******************************************************************************/


// Default namespace
namespace App;
use App\Components\Session;


/**
 * Main class
 */
class Main extends \Gaia\Controllers\Twig
{



    /**
     * @param null $key
     */
    public function show($key = null) {

        $Session = Session::getInstance();

        $formattedLatestUrls = $Session->getLatestUrls();

        $usersLatetUrls = (!empty($formattedLatestUrls) && \is_array($formattedLatestUrls)) ? $formattedLatestUrls : null;

//        var_dump($usersLatetUrls); die;

        $key = $this->getRequest()->getURI();

        // 404
//        if ($this->getRequest()->is404()) {
//            // Show error page
//            $this->display("pages/error/404.twig");
//
//            // Exit
//            exit();
//        }

        // Assign content
        $this->assign("data", [
            "title"   => "URL SHortener",
            "latestUrls" => $usersLatetUrls
        ]);

        if (!$key) {
            // Render template with form
            $this->display("shortener/index.twig");

        } else {
            $this->redirectUrl($key);
        }
    }

    /**
     * Permanent redirect from short url to long url
     *
     * @param $key
     * @return array
     */
    public function redirectUrl($key)
    {
        // Set root path
        $rootPath = 'http://' . \getenv('HTTP_HOST') . \dirname(getenv('SCRIPT_NAME'));
//        $response = new JsonResponse();
        $shortUrl = $rootPath . $key;

        // @TODO: WEAK PLACE
        // Try to get url
        $Url = $this->getDoctrine()->getRepository("App\\Models\\Url")->findOneBy(["shortUrl" => $shortUrl]);
        if (!$Url) {
            return $this->redirect("/");
        } else {
            // Set view
//            $responseResult = $this->setUrlViews($Url);
            $this->setUrlViews($Url);

            if ($Url instanceof \App\Entities\Url) {
                // Permanent redirect to url
                return $this->redirect($Url->getUrl(), 301);
            }
//            else {
//                return $response->setData([
//                    'response' => $responseResult
//                ]);
//            }
        }
    }


    /**
     * Count views for url
     *
     * @param Entities\Url $Url
     * @return null|string
     */
    private function setUrlViews(\App\Entities\Url $Url)
    {
        // Get entity manager
        $EM = $this->getDoctrine()->getEntityManager();

        // Set views
        try {
            $views = $Url->getViews();
            $Url->setViews($views + 1);
            $EM->flush();
            return null;
        } catch (\Exception $Exception) {
            $Error = new \Exception(\App\Libraries\Error\Code::CAN_NOT_SET_VIEW);
            return $Error->getMessage();
        }
    }

}