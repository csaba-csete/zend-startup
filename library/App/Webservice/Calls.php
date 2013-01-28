<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michael
 * Date: 15.09.11
 * Time: 06:44
 * To change this template use File | Settings | File Templates.
 */
namespace App\Webservice;

class Calls
{
    /**
     * Returns a random quote using the RandomQuote Service
     * @param App_Webservice_Types_Request_RandomQuoteRequest $request
     * @return  App_Webservice_Types_Response_RandomQuoteResponse $response
     */
    public function randomQuote()
    {
        $serviceContainer = \Zend_Registry::get('sc');
        $srv = $serviceContainer->getService('randomQuote');
        $quote = $srv->getQuote();
        $response = new \App_Webservice_Types_Response_RandomQuoteResponse();
        $response->quote->wording = $quote[0];
        $response->quote->author = $quote[1];
        return $response;
    }

    /**
     * Returns a quote from the Database using an ID given
     * @param App_Webservice_Types_Request_QuoteRequest $request
     * @return  App_Webservice_Types_Response_QuoteResponse $response
     */
    public function quote($request)
    {   
        $entityManager = \Zend_Registry::get('em');
        $quote = $entityManager->getRepository("\App\Entity\Quote")->find($request->id);
        $response = new \App_Webservice_Types_Response_QuoteResponse();

        if (!is_null($quote)) {
            $response->quote->wording = $quote->getWording();
            $response->quote->author = $quote->getAuthor();
            return $response;
        } else {
            return new \SoapFault(
                (string) "404", "Quote with ID " .
                ($request->id) . " not found in DB."
            );
        }
    }
}
