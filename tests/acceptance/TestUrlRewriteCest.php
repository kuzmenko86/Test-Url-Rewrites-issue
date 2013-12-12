<?php
use \WebGuy;

class TestUrlRewriteCest
{
    /**
     * variable $search and $fileLocation should be changed
     *
     * function getcwd(); can be help us find correct place for file location
     *
     * @param WebGuy $I
     */
    public function tryToTest(WebGuy $I)
    {
        $search = "http://www.claudiastrater.com";
        $fileLocation = "../projectstests/url-rewrite/tests/acceptance/301Redirects.csv";

        $I->wantTo("Check if url rewrites were imported correct");

        $I->amOnPage('/');

        if (($handle = fopen($fileLocation, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {

                $requestPath = str_replace($search, "", $data[0]);
                $targetPath = str_replace($search, "", $data[1]);


                if (strlen($targetPath) > 1){
                    $targetPath = rtrim($targetPath, "/");
                }

                $I->amOnPage($requestPath);
                $I->canSeeCurrentUrlEquals($targetPath);

            }
            fclose($handle);
        }
    }
}