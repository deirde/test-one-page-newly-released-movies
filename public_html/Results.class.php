<?php

/**
 * Newly released movies by APIs.
 */
namespace Deirde\NewlyReleasedMovies {

    class Results
    {

        /**
         * The available API urls.
         */
        private $apiUrls =
        [
            'allNewlyReleasedItems' => 'http://skyatlasroku.eu-west-1.elasticbeanstalk.com/api/media/',
            'itemDetailsById' => 'http://skyatlasroku.eu-west-1.elasticbeanstalk.com/api/media/<movie_id>',
            'salePriceItemByIdAndCurrency' => 'http://skyatlasroku.eu-west-1.elasticbeanstalk.com/api/pricing/<movie_id>/<currency>/',
        ];

        /**
         * The available currencies.
         */
        private $currencies =
        [
            'GBP',
            'EUR'
        ];

        /**
         * Returns the page title.
         * @return string
         */
        public function pageTitle()
        {

            return _('One page newly released movies');

        }

        /**
         * Returns the item image url.
         * @param $item
         * @return string
         */
        private function getImageByItem($item)
        {

            if (!$response = $item->imageURL) {
                $response = '/assets/movie_placeholder.png';
            }

            return $response;
        }

        /**
         * Adds the <imageURL> property to the item object.
         * @param $item
         * @return object
         */
        private function setImageByItem($item)
        {

            $item->imageURL = $this->getImageByItem($item);

            return $item;

        }

        /**
         * Returns the item prices.
         * @param $item_id
         * @param $currency
         * @return mixed
         */
        private function getPriceByIdAndCurrency($item_id, $currency)
        {

            $apiUrl = str_replace('<movie_id>', $item_id, $this->apiUrls['salePriceItemByIdAndCurrency']);
            $apiUrl = str_replace('<currency>', $currency, $apiUrl);

            if ($contents = json_decode(@file_get_contents($apiUrl)))
            {
                return money_format('%i', $contents->price);
            }
            else
            {
                return false;
            }

        }

        /**
         * Adds the <price> property to the item object.
         * @param $item
         * @return object
         */
        private function setPriceByItem($item)
        {

            foreach ($this->currencies as $currency) {
                if ($price = $this->getPriceByIdAndCurrency($item->id, $currency)) {
                    $item->price{$currency} = $price;
                }
            }

            return $item;

        }

        /**
         * Gets all available items.
         * @return array
         */
        public function getAllNewlyReleasedItems()
        {

            $items = json_decode(file_get_contents($this->apiUrls['allNewlyReleasedItems']));

            for ($i = 0; $i <= count($items); $i++) {

                $items[$i] = $this->setPriceByItem($items[$i]);

                if (!isset($items[$i]->price)) {
                    unset($items[$i]);
                } else {
                    $items[$i] = $this->setImageByItem($items[$i]);
                }

            }

            return $items;

        }

    }

}

?>