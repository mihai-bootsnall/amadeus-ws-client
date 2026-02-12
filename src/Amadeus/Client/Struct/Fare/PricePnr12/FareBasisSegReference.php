<?php
/**
 * amadeus-ws-client
 *
 * Copyright 2015 Amadeus Benelux NV
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package Amadeus
 * @license https://opensource.org/licenses/Apache-2.0 Apache 2.0
 */

namespace Amadeus\Client\Struct\Fare\PricePnr12;

/**
 * FareBasisSegReference
 *
 * XSD 12_4: one fareBasisSegReference contains multiple refDetails (sequence).
 * PHP SoapClient reads the "refDetails" property by name; if it's an array it
 * tries to encode the array as one refDetails (no refQualifier). So we store
 * multiple refDetails in a private list and expose them only via getIterator(),
 * and remove the public refDetails so the encoder iterates this object and gets
 * RefDetails instances.
 *
 * @package Amadeus\Client\Struct\Fare\PricePnr12
 * @author dieter <dermikagh@gmail.com>
 */
class FareBasisSegReference implements \IteratorAggregate
{
    /**
     * @var RefDetails
     */
    public $refDetails;

    /**
     * Multiple refDetails for XSD "sequence of refDetails"; not exposed as property.
     *
     * @var RefDetails[]
     */
    private $refDetailsList = [];

    /**
     * FareBasisSegReference constructor.
     *
     * @param $segmentNr
     * @param $qualifier
     */
    public function __construct($segmentNr, $qualifier)
    {
        $this->refDetails = new RefDetails($segmentNr, $qualifier);
    }

    /**
     * Set multiple refDetails for SOAP; caller must then unset($obj->refDetails) so encoder iterates this.
     *
     * @param RefDetails[] $list
     */
    public function setRefDetailsList(array $list)
    {
        $this->refDetailsList = $list;
    }

    /**
     * SoapClient iterates this when encoding "sequence of refDetails"; yield RefDetails.
     *
     * @return \ArrayIterator
     */
    public function getIterator(): \ArrayIterator
    {
        $list = !empty($this->refDetailsList) ? $this->refDetailsList : [$this->refDetails];
        return new \ArrayIterator($list);
    }
}
