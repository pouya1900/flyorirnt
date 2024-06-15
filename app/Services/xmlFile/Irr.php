<?php


namespace App\Services\xmlFile;

use App\Services\MyHelperFunction;

class Irr
{

    public $agent_id;

    public function __construct($agent_id)
    {

        $this->agent_id = $agent_id;

    }

    public function LowFareSearch($data)
    {


        $req = '<OTA_AirLowFareSearchRQ xmlns="http://www.opentravel.org/OTA/2003/05"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05
  OTA_AirLowFareSearchRQ.xsd" EchoToken="50987" TimeStamp="' . date('Y-m-d\TH:i:s.uP', strtotime('now')) . '"
  Target="Production" Version="2.001" SequenceNmbr="1" PrimaryLangID="En-us">
    <POS>
        <Source AirlineVendorID="IR" ISOCountry="IR" ISOCurrency="EUR">
            <RequestorID Type="5" ID="' . $this->agent_id . '"/>
        </Source>
    </POS>
    <OriginDestinationInformation>
        <DepartureDateTime>' . $data["OriginDestinationInformations"][0]["DepartureDateTime"] . '</DepartureDateTime>
        <OriginLocation LocationCode="' . $data["OriginDestinationInformations"][0]["OriginLocationCode"] . '"/>
        <DestinationLocation LocationCode="' . $data["OriginDestinationInformations"][0]["DestinationLocationCode"] . '"/>
    </OriginDestinationInformation>';
        if ($data["TravelPreference"]["AirTripType"] == "Return") {
            $req .= '
    <OriginDestinationInformation>
        <DepartureDateTime>' . $data["OriginDestinationInformations"][1]["DepartureDateTime"] . '</DepartureDateTime>
        <OriginLocation LocationCode="' . $data["OriginDestinationInformations"][1]["OriginLocationCode"] . '"/>
        <DestinationLocation LocationCode="' . $data["OriginDestinationInformations"][1]["DestinationLocationCode"] . '"/>
    </OriginDestinationInformation>';
        }
        if ($data["TravelPreference"]["AirTripType"] == "Multi") {
            $req .= '
    <OriginDestinationInformation>
        <DepartureDateTime>' . $data["OriginDestinationInformations"][1]["DepartureDateTime"] . '</DepartureDateTime>
        <OriginLocation LocationCode="' . $data["OriginDestinationInformations"][1]["OriginLocationCode"] . '"/>
        <DestinationLocation LocationCode="' . $data["OriginDestinationInformations"][1]["DestinationLocationCode"] . '"/>
    </OriginDestinationInformation>';
            if (isset($data["OriginDestinationInformations"][2])) {
                $req .= '
    <OriginDestinationInformation>
        <DepartureDateTime>' . $data["OriginDestinationInformations"][2]["DepartureDateTime"] . '</DepartureDateTime>
        <OriginLocation LocationCode="' . $data["OriginDestinationInformations"][2]["OriginLocationCode"] . '"/>
        <DestinationLocation LocationCode="' . $data["OriginDestinationInformations"][2]["DestinationLocationCode"] . '"/>
    </OriginDestinationInformation>';
            }
            if (isset($data["OriginDestinationInformations"][3])) {
                $req .= '
    <OriginDestinationInformation>
        <DepartureDateTime>' . $data["OriginDestinationInformations"][3]["DepartureDateTime"] . '</DepartureDateTime>
        <OriginLocation LocationCode="' . $data["OriginDestinationInformations"][3]["OriginLocationCode"] . '"/>
        <DestinationLocation LocationCode="' . $data["OriginDestinationInformations"][3]["DestinationLocationCode"] . '"/>
    </OriginDestinationInformation>';
            }
        }
        $req .= '
    <TravelPreferences >
        <CabinPref  Cabin="' . $data["TravelPreference"]["CabinType"] . '"/>
    </TravelPreferences>
    <TravelerInfoSummary>
        <AirTravelerAvail>
            <PassengerTypeQuantity Code="ADT" Quantity="' . $data["AdultCount"] . '"/>
            <PassengerTypeQuantity Code="CHD" Quantity="' . $data["ChildCount"] . '"/>
            <PassengerTypeQuantity Code="INF" Quantity="' . $data["InfantCount"] . '"/>
        </AirTravelerAvail>
    </TravelerInfoSummary>
    <ProcessingInfo SearchType="' . $data["searchType"] . '"/>
</OTA_AirLowFareSearchRQ>';

        return $req;

    }


    public function airRule($flight)
    {

        $req = '<OTAPSS_AirFareRuleRQ xmlns="http://www.opentravel.org/OTA/2003/05" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05   OTAPSS_AirFareRuleRQ.xsd" EchoToken="11231" TimeStamp="' . date('Y-m-d\TH:i:s.uP', strtotime('now')) . '" Target="Production" Version="2.001" SequenceNmbr="1" PrimaryLangID="En-us">
    <POS>
        <Source AirlineVendorID="IR" ISOCountry="IR" ISOCurrency="EUR">
            <RequestorID Type="5" ID="' . $this->agent_id . '"/>
        </Source>
    </POS>
   <OriginDestinationOptions>
      <OriginDestinationOption>
        <FlightSegment FlightNumber="' . $flight["flight_number"] . '" ResBookDesigCode="' . $flight["class_code"] . '" DepartureDateTime="' . $flight["depart_time"] . '" ArrivalDateTime="' . $flight["arrival_time"] . '" Duration="' . MyHelperFunction::turn_min_to_time($flight["total_time"]) . '" StopQuantity="' . $flight["stops"] . '" RPH="' . $flight["legs"][0]["RPH"] . '">
           <DepartureAirport LocationCode="' . $flight["depart_airport"] . '"/>
           <ArrivalAirport LocationCode="' . $flight["arrival_airport"] . '"/>
           <OperatingAirline Code="' . $flight["legs"][0]["leg_airline_code"] . '"/>
           <Equipment AirEquipType="' . $flight["legs"][0]["aircraft_type"] . '"/>
           <BookingClassAvails>
              <BookingClassAvail ResBookDesigCode="' . $flight["class_code"] . '" ResBookDesigQuantity="' . $flight["legs"][0]["seats_remaining"] . '"/>
           </BookingClassAvails>
        </FlightSegment>
      </OriginDestinationOption>
      ';
        if ($flight["DirectionInd"] == 2) {
            $req .= ' <OriginDestinationOption>
        <FlightSegment FlightNumber="' . $flight["return_flight_number"] . '" ResBookDesigCode="' . $flight["return_class_code"] . '" DepartureDateTime="' . $flight["return_depart_time"] . '" ArrivalDateTime="' . $flight["return_arrival_time"] . '" Duration="' . MyHelperFunction::turn_min_to_time($flight["return_total_time"]) . '" StopQuantity="' . $flight["return_stops"] . '" RPH="' . $flight["legs"][1]["RPH"] . '">
           <DepartureAirport LocationCode="' . $flight["return_depart_airport"] . '"/>
           <ArrivalAirport LocationCode="' . $flight["return_arrival_airport"] . '"/>
           <OperatingAirline Code="' . $flight["legs"][1]["leg_airline_code"] . '"/>
           <Equipment AirEquipType="' . $flight["legs"][1]["aircraft_type"] . '"/>
           <BookingClassAvails>
              <BookingClassAvail ResBookDesigCode="' . $flight["return_class_code"] . '" ResBookDesigQuantity="' . $flight["legs"][1]["seats_remaining"] . '"/>
           </BookingClassAvails>
        </FlightSegment>
      </OriginDestinationOption>';
        }

        $req .= '</OriginDestinationOptions>
   <FareBasisCodes>
      <FareBasisCode FlightSegmentRPH="' . $flight["legs"][0]["RPH"] . '" fareRPH="' . $flight["legs"][0]["fareRPH"] . '">' . $flight["legs"][0]["fare_basis_code"] . '</FareBasisCode>
  ';
        if ($flight["DirectionInd"] == 2) {
            $req .= '      <FareBasisCode FlightSegmentRPH="' . $flight["legs"][1]["RPH"] . '" fareRPH="' . $flight["legs"][1]["fareRPH"] . '">' . $flight["legs"][1]["fare_basis_code"] . '</FareBasisCode>';
        }

        $req .= '</FareBasisCodes>
</OTAPSS_AirFareRuleRQ>';

        return $req;
    }


    public function book($payment)
    {

        $flight = $payment->books->flights;

        $inf_count = $payment->books->flights->costs->infant;

        $domestic = 0;
        if ($flight->airports1->country == "IR" && $flight->airports2->country == "IR") {
            $domestic = 1;
        }

        $req = '<OTA_AirBookRQ xmlns="http://www.opentravel.org/OTA/2003/05"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05
  OTA_AirBookRQ.xsd" EchoToken="50987" TimeStamp="' . date('Y-m-d\TH:i:s.uP', strtotime('now')) . '"
  Target="Production" Version="2.001" SequenceNmbr="1" PrimaryLangID="En-us">
    <POS>
        <Source AirlineVendorID="IR" ISOCountry="IR" ISOCurrency="EUR">
            <RequestorID Type="5" ID="' . $this->agent_id . '"/>
        </Source>
    </POS>
    <AirItinerary DirectionInd="' . ($flight->DirectionInd == 2 ? "Return" : "OneWay") . '">
	<OriginDestinationOptions>
      <OriginDestinationOption>
        <FlightSegment FlightNumber="' . $flight->flight_number . '" ResBookDesigCode="' . $flight->class_code . '" DepartureDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->depart_time)) . '" ArrivalDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->arrival_time)) . '" Duration="' . MyHelperFunction::turn_min_to_time($flight->total_time) . ':00" StopQuantity="' . $flight->stops . '" RPH="' . $flight->legs[0]->RPH . '">
           <DepartureAirport LocationCode="' . $flight->depart_airport . '"/>
           <ArrivalAirport LocationCode="' . $flight->arrival_airport . '"/>
           <OperatingAirline Code="' . $flight->legs[0]->leg_airline_code . '"/>
           <Equipment AirEquipType="' . $flight->legs[0]->aircraft_type . '"/>
           <BookingClassAvails>
              <BookingClassAvail ResBookDesigCode="' . $flight->class_code . '" ResBookDesigQuantity="' . $flight->legs[0]->seats_remaining . '"/>
           </BookingClassAvails>
        </FlightSegment>
      </OriginDestinationOption>
      ';
        if ($flight["DirectionInd"] == 2) {
            $req .= ' <OriginDestinationOption>
        <FlightSegment FlightNumber="' . $flight->return_flight_number . '" ResBookDesigCode="' . $flight->return_class_code . '" DepartureDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->return_depart_time)) . '" ArrivalDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->return_arrival_time)) . '" Duration="' . MyHelperFunction::turn_min_to_time($flight->return_total_time) . '" StopQuantity="' . $flight->return_stops . '" RPH="' . $flight->legs[1]->RPH . '">
           <DepartureAirport LocationCode="' . $flight->return_depart_airport . '"/>
           <ArrivalAirport LocationCode="' . $flight->return_arrival_airport . '"/>
           <OperatingAirline Code="' . $flight->legs[1]->leg_airline_code . '"/>
           <Equipment AirEquipType="' . $flight->legs[1]->aircraft_type . '"/>
           <BookingClassAvails>
              <BookingClassAvail ResBookDesigCode="' . $flight->return_class_code . '" ResBookDesigQuantity="' . $flight->legs[1]->seats_remaining . '"/>
           </BookingClassAvails>
        </FlightSegment>
      </OriginDestinationOption>';
        }

        $req .= '</OriginDestinationOptions>
	</AirItinerary>
	<PriceInfo>
        <ItinTotalFare>
             <BaseFare CurrencyCode="' . $flight->costs->Currency . '" DecimalPlaces="2" Amount="' . number_format(($flight->costs->VendorTotalFare - $flight->costs->TotalTax), 2, ".", "") . '"/>
             <TotalFare CurrencyCode="' . $flight->costs->Currency . '" DecimalPlaces="2" Amount="' . number_format($flight->costs->VendorTotalFare, 2, ".", "") . '"/>
        </ItinTotalFare>
	</PriceInfo>
	<TravelerInfo>';

        $i = 0;
        foreach ($payment->books->passengers as $item) {
            $i++;
            $req .= '
		<AirTraveler BirthDate="' . $item->birthday . '" PassengerTypeCode="' . MyHelperFunction::turn_type_code($item->type) . '" AccompaniedByInfantInd="';

            if ($inf_count > 0) {
                $req .= 'true';
                $inf_count--;
            } else {
                $req .= 'false';
            }
            $req .= '" Gender="' . ($item->gender == 0 ? "M" : "F") . '" TravelerNationality="' . $item->country . '">
			<PersonName>
				<NamePrefix>' . MyHelperFunction::turn_title_code($item->gender, $item->type) . '</NamePrefix>
				<GivenName>' . $item->first_name . '</GivenName>
				<Surname>' . $item->last_name . '</Surname>
			</PersonName>
			<TravelerRefNumber RPH="' . $i . '"/>';

            if ($item->country == "IR" && $domestic == 1) {
                $req .= '<Document  DocID="' . $item->national_id . '" DocType="5" DocIssueCountry="' . $item->country . '" DocHolderNationality="' . $item->country . '"/>';
            } else {
                $req .= '<Document  DocID="' . $item->passport_number . '" DocType="2" ExpireDate="' . $item->expiry_date . '" DocIssueCountry="' . $item->country . '" DocHolderNationality="' . $item->country . '"/>';
            }

            $req .= '<Address Type="4">
<AddressLine>Grafen-Berg-Platz 2</AddressLine>
<CityName>Dusseldorf</CityName>
<CountryName Code="DE"/>
</Address>

		</AirTraveler>';
        }

        $req .= '</TravelerInfo>
	<ContactPerson>
            <PersonName>
                <GivenName>' . $payment->books->arranger_first_name . '</GivenName>
                <Surname>' . $payment->books->arranger_last_name . '</Surname>
            </PersonName>
		  <Telephone PhoneNumber="(' . substr($payment->books->dial_code, 1) . ')' . $payment->books->phone . '"/>
		  <HomeTelephone PhoneNumber="(98)21236541"/>
        <Email>' . $payment->books->users->email . '</Email>

    </ContactPerson>
    <Fulfillment>
        <PaymentDetails>
            <PaymentDetail PaymentType="2">
                <DirectBill DirectBill_ID="' . $this->agent_id . '">
                    <CompanyName CompanyShortName="FLY ORIENT" Code="' . $this->agent_id . '"/>
                </DirectBill>
                <PaymentAmount CurrencyCode="' . $flight->costs->Currency . '" DecimalPlaces="2" Amount="' . number_format($flight->costs->VendorTotalFare, 2, ".", "") . '"/>
            </PaymentDetail>
        </PaymentDetails>
    </Fulfillment>
</OTA_AirBookRQ>
';


        return $req;

    }


    public function book_data($book_unique_id)
    {

        $req = '<OTA_ReadRQ xmlns="http://www.opentravel.org/OTA/2003/05"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05 OTA_ReadRQ.xsd"
  EchoToken="50987"  TimeStamp="' . date('Y-m-d\TH:i:s.uP', strtotime('now')) . '" Target="Production" Version="2.001" SequenceNmbr="1" PrimaryLangID="En-us">
    <POS>
        <Source AirlineVendorID="IR" ISOCountry="IR" ISOCurrency="EUR">
            <RequestorID Type="5" ID="' . $this->agent_id . '"/>
        </Source>
    </POS>
  <UniqueID ID="' . $book_unique_id . '"/>
</OTA_ReadRQ>';

        return $req;

    }


    public function cancel_fee($book)
    {

        $flight = $book->flights;

        $req = '<OTA_AirBookModifyRQ xmlns="http://www.opentravel.org/OTA/2003/05"
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05
OTA_AirBookRQ.xsd" EchoToken="50987" TimeStamp="' . date('Y-m-d\TH:i:s.uP', strtotime('now')) . '"
Target="Production" Version="2.001" SequenceNmbr="1" PrimaryLangID="En-us">
<POS>
   <Source AirlineVendorID="IR" ISOCountry="IR" ISOCurrency="EUR">
       <RequestorID Type="5" ID="' . $this->agent_id . '"/>
   </Source>
</POS>
<AirBookModifyRQ ModificationType="1"></AirBookModifyRQ>
<AirReservation>

<AirItinerary DirectionInd="' . ($flight->DirectionInd == 2 ? "Return" : "OneWay") . '">
	<OriginDestinationOptions>
      <OriginDestinationOption>
        <FlightSegment Status="39" FlightNumber="' . $flight->flight_number . '" ResBookDesigCode="' . $flight->class_code . '" DepartureDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->depart_time)) . '" ArrivalDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->arrival_time)) . '" Duration="' . MyHelperFunction::turn_min_to_time($flight->total_time) . ':00" StopQuantity="' . $flight->stops . '" RPH="' . $flight->legs[0]->RPH . '">
           <DepartureAirport LocationCode="' . $flight->depart_airport . '"/>
           <ArrivalAirport LocationCode="' . $flight->arrival_airport . '"/>
           <OperatingAirline Code="' . $flight->legs[0]->leg_airline_code . '"/>
           <Equipment AirEquipType="' . $flight->legs[0]->aircraft_type . '"/>
        </FlightSegment>
      </OriginDestinationOption>
      ';
        if ($flight["DirectionInd"] == 2) {
            $req .= ' <OriginDestinationOption>
        <FlightSegment Status="39" FlightNumber="' . $flight->return_flight_number . '" ResBookDesigCode="' . $flight->return_class_code . '" DepartureDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->return_depart_time)) . '" ArrivalDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->return_arrival_time)) . '" Duration="' . MyHelperFunction::turn_min_to_time($flight->return_total_time) . '" StopQuantity="' . $flight->return_stops . '" RPH="' . $flight->legs[1]->RPH . '">
           <DepartureAirport LocationCode="' . $flight->return_depart_airport . '"/>
           <ArrivalAirport LocationCode="' . $flight->return_arrival_airport . '"/>
           <OperatingAirline Code="' . $flight->legs[1]->leg_airline_code . '"/>
           <Equipment AirEquipType="' . $flight->legs[1]->aircraft_type . '"/>
           </FlightSegment>
      </OriginDestinationOption>';
        }

        $req .= '</OriginDestinationOptions>
	</AirItinerary>

   <BookingReferenceID Status="39" Instance="0" ID="' . $book->UniqueId . '" ID_Context="BookingRef"/>
</AirReservation>
</OTA_AirBookModifyRQ>';

        return $req;
    }

    public function cancel($book)
    {

        $flight = $book->flights;

        $req = '<OTA_AirBookModifyRQ xmlns="http://www.opentravel.org/OTA/2003/05"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05
  OTA_AirBookModifyRQ.xsd" EchoToken="50987" TimeStamp="' . date('Y-m-d\TH:i:s.uP', strtotime('now')) . '"
  Target="Production" Version="2.001" SequenceNmbr="1"  PrimaryLangID="En-us">
	<POS>
	   <Source AirlineVendorID="IR" ISOCountry="IR" ISOCurrency="EUR">
	       <RequestorID Type="5" ID="' . $this->agent_id . '"/>
	   </Source>
	</POS>
  <AirBookModifyRQ ModificationType="1">
      <Fulfillment>
           <PaymentDetails>
                <PaymentDetail PaymentType="2">
	               <DirectBill DirectBill_ID="' . $this->agent_id . '">
	                  <CompanyName CompanyShortName="FLY ORIENT" Code="' . $this->agent_id . '" AgentType="TRVL_AGNT"/>
	               </DirectBill>
                    <PaymentAmount CurrencyCode="' . $flight->costs->Currency . '" DecimalPlaces="0" Amount="00.00"/>
                </PaymentDetail>
            </PaymentDetails>
      </Fulfillment>
    </AirBookModifyRQ>
    <AirReservation>

<AirItinerary DirectionInd="' . ($flight->DirectionInd == 2 ? "Return" : "OneWay") . '">
	<OriginDestinationOptions>
      <OriginDestinationOption>
        <FlightSegment Status="39" FlightNumber="' . $flight->flight_number . '" ResBookDesigCode="' . $flight->class_code . '" DepartureDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->depart_time)) . '" ArrivalDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->arrival_time)) . '" Duration="' . MyHelperFunction::turn_min_to_time($flight->total_time) . ':00" StopQuantity="' . $flight->stops . '" RPH="' . $flight->legs[0]->RPH . '">
           <DepartureAirport LocationCode="' . $flight->depart_airport . '"/>
           <ArrivalAirport LocationCode="' . $flight->arrival_airport . '"/>
           <OperatingAirline Code="' . $flight->legs[0]->leg_airline_code . '"/>
           <Equipment AirEquipType="' . $flight->legs[0]->aircraft_type . '"/>
           </FlightSegment>
      </OriginDestinationOption>
      ';
        if ($flight["DirectionInd"] == 2) {
            $req .= ' <OriginDestinationOption>
        <FlightSegment Status="39" FlightNumber="' . $flight->return_flight_number . '" ResBookDesigCode="' . $flight->return_class_code . '" DepartureDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->return_depart_time)) . '" ArrivalDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->return_arrival_time)) . '" Duration="' . MyHelperFunction::turn_min_to_time($flight->return_total_time) . '" StopQuantity="' . $flight->return_stops . '" RPH="' . $flight->legs[1]->RPH . '">
           <DepartureAirport LocationCode="' . $flight->return_depart_airport . '"/>
           <ArrivalAirport LocationCode="' . $flight->return_arrival_airport . '"/>
           <OperatingAirline Code="' . $flight->legs[1]->leg_airline_code . '"/>
           <Equipment AirEquipType="' . $flight->legs[1]->aircraft_type . '"/>
           </FlightSegment>
      </OriginDestinationOption>';
        }

        $req .= '</OriginDestinationOptions>
	</AirItinerary>

      <Fulfillment>
         <PaymentDetails>
            <PaymentDetail PaymentType="2">
               <DirectBill DirectBill_ID="' . $this->agent_id . '">
                  <CompanyName CompanyShortName="FLY ORIENT" Code="' . $this->agent_id . '" AgentType="TRVL_AGNT"/>
               </DirectBill>
                <PaymentAmount CurrencyCode="' . $flight->costs->Currency . '" DecimalPlaces="2" Amount="' . number_format($flight->costs->VendorTotalFare, 2, ".", "") . '"/>
            </PaymentDetail>
         </PaymentDetails>
      </Fulfillment>
        <BookingReferenceID Status="39" Instance="0" ID="' . $book->UniqueId . '" ID_Context="BookingRef"/>
        </AirReservation>
</OTA_AirBookModifyRQ>
';

        return $req;
    }


    public function split($book)
    {


        $flight = $book->flights;

        $inf_count = $book->flights->costs->infant;

        $domestic = 0;
        if ($flight->airports1->country == "IR" && $flight->airports2->country == "IR") {
            $domestic = 1;
        }

        $req = '<OTA_AirBookModifyRQ xmlns="http://www.opentravel.org/OTA/2003/05"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05
  OTA_AirBookModifyRQ.xsd" EchoToken="50987" TimeStamp="' . date('Y-m-d\TH:i:s.uP', strtotime('now')) . '"
  Target="Production" Version="2.001" SequenceNmbr="1"  PrimaryLangID="En-us">
	<POS>
	   <Source AirlineVendorID="IR" ISOCountry="IR" ISOCurrency="EUR">
	       <RequestorID Type="5" ID="' . $this->agent_id . '"/>
	   </Source>
	</POS>
	<AirBookModifyRQ ModificationType="6">
		<TravelerInfo>';

        $i = 0;
        $item = $book->passengers[0];
        $i++;
        $req .= '
		<AirTraveler BirthDate="' . $item->birthday . '" PassengerTypeCode="' . MyHelperFunction::turn_type_code($item->type) . '" AccompaniedByInfantInd="';

        if ($inf_count > 0) {
            $req .= 'true';
            $inf_count--;
        } else {
            $req .= 'false';
        }

        $req .= '" Gender="' . ($item->gender == 0 ? "M" : "F") . '" TravelerNationality="' . $item->country . '">
			<PersonName>
				<NamePrefix>' . MyHelperFunction::turn_title_code($item->gender, $item->type) . '</NamePrefix>
				<GivenName>' . $item->first_name . '</GivenName>
				<Surname>' . $item->last_name . '</Surname>
			</PersonName>
			<TravelerRefNumber RPH="' . $i . '"/>';

        if ($item->country == "IR" && $domestic == 1) {
            $req .= '<Document  DocID="' . $item->national_id . '" DocType="5" DocIssueCountry="' . $item->country . '" DocHolderNationality="' . $item->country . '"/>';
        } else {
            $req .= '<Document  DocID="' . $item->passport_number . '" DocType="2" ExpireDate="' . $item->expiry_date . '" DocIssueCountry="' . $item->country . '" DocHolderNationality="' . $item->country . '"/>';
        }

        $req .= '

		</AirTraveler>';


        $req .= '</TravelerInfo>
	</AirBookModifyRQ>
	<AirReservation>
     <AirItinerary DirectionInd="' . ($flight->DirectionInd == 2 ? "Return" : "OneWay") . '">
	<OriginDestinationOptions>
      <OriginDestinationOption>
        <FlightSegment Status="39" FlightNumber="' . $flight->flight_number . '" ResBookDesigCode="' . $flight->class_code . '" DepartureDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->depart_time)) . '" ArrivalDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->arrival_time)) . '" Duration="' . MyHelperFunction::turn_min_to_time($flight->total_time) . ':00" StopQuantity="' . $flight->stops . '" RPH="' . $flight->legs[0]->RPH . '">
           <DepartureAirport LocationCode="' . $flight->depart_airport . '" />
           <ArrivalAirport LocationCode="' . $flight->arrival_airport . '"/>
           <OperatingAirline Code="' . $flight->legs[0]->leg_airline_code . '"/>
           <Equipment AirEquipType="' . $flight->legs[0]->aircraft_type . '"/>
           </FlightSegment>
      </OriginDestinationOption>
      ';
        if ($flight["DirectionInd"] == 2) {
            $req .= ' <OriginDestinationOption>
        <FlightSegment Status="39" FlightNumber="' . $flight->return_flight_number . '" ResBookDesigCode="' . $flight->return_class_code . '" DepartureDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->return_depart_time)) . '" ArrivalDateTime="' . date('Y-m-d\TH:i:s.uP', strtotime($flight->return_arrival_time)) . '" Duration="' . MyHelperFunction::turn_min_to_time($flight->return_total_time) . '" StopQuantity="' . $flight->return_stops . '" RPH="' . $flight->legs[1]->RPH . '">
           <DepartureAirport LocationCode="' . $flight->return_depart_airport . '"/>
           <ArrivalAirport LocationCode="' . $flight->return_arrival_airport . '" />
           <OperatingAirline Code="' . $flight->legs[1]->leg_airline_code . '"/>
           <Equipment AirEquipType="' . $flight->legs[1]->aircraft_type . '"/>
           </FlightSegment>
      </OriginDestinationOption>';
        }

        $req .= '</OriginDestinationOptions>
	</AirItinerary>
	 <TravelerInfo>';

        $i = 0;
        foreach ($book->passengers as $item) {
            $i++;
            $req .= '
		<AirTraveler BirthDate="' . $item->birthday . '" PassengerTypeCode="' . MyHelperFunction::turn_type_code($item->type) . '" AccompaniedByInfantInd="';

            if ($inf_count > 0) {
                $req .= 'true';
                $inf_count--;
            } else {
                $req .= 'false';
            }
            $req .= '" Gender="' . ($item->gender == 0 ? "M" : "F") . '" TravelerNationality="' . $item->country . '">
			<PersonName>
				<NamePrefix>' . MyHelperFunction::turn_title_code($item->gender, $item->type) . '</NamePrefix>
				<GivenName>' . $item->first_name . '</GivenName>
				<Surname>' . $item->last_name . '</Surname>
			</PersonName>
			<TravelerRefNumber RPH="' . $i . '"/>';

            if ($item->country == "IR" && $domestic == 1) {
                $req .= '<Document  DocID="' . $item->national_id . '" DocType="5" DocIssueCountry="' . $item->country . '" DocHolderNationality="' . $item->country . '"/>';
            } else {
                $req .= '<Document  DocID="' . $item->passport_number . '" DocType="2" ExpireDate="' . $item->expiry_date . '" DocIssueCountry="' . $item->country . '" DocHolderNationality="' . $item->country . '"/>';
            }

            $req .= '

		</AirTraveler>';
        }

        $req .= '</TravelerInfo>
	<Fulfillment>
         <PaymentDetails>
            <PaymentDetail PaymentType="2">
               <DirectBill DirectBill_ID="' . $this->agent_id . '">
                  <CompanyName CompanyShortName="FLY ORIENT" Code="' . $this->agent_id . '" AgentType="TRVL_AGNT"/>
               </DirectBill>
                <PaymentAmount CurrencyCode="' . $flight->costs->Currency . '" DecimalPlaces="2" Amount="' . number_format($flight->costs->VendorTotalFare, 2, ".", "") . '"/>
            </PaymentDetail>
         </PaymentDetails>
      </Fulfillment>
        <BookingReferenceID Status="39" Instance="0" ID="' . $book->UniqueId . '" ID_Context="BookingRef"/>
	</AirReservation>
</OTA_AirBookModifyRQ>
';

        return $req;
    }

    public function edit($book)
    {
        $req = '<OTA_AirBookModifyRQ xmlns="http://www.opentravel.org/OTA/2003/05"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05
  OTA_AirBookModifyRQ.xsd" EchoToken="50987" TimeStamp="' . date('Y-m-d\TH:i:s.uP', strtotime('now')) . '"
  Target="Production" Version="4.001" SequenceNmbr="1"  PrimaryLangID="En-us">
	<POS>
	   <Source AirlineVendorID="IR" ISOCountry="IR" ISOCurrency="EUR">
	       <RequestorID Type="5" ID="' . $this->agent_id . '"/>
	   </Source>
	</POS>
	<AirBookModifyRQ ModificationType="20">
	 <ContactPerson>
            <PersonName>
                <GivenName>' . $book->arranger_first_name . '</GivenName>
                <Surname>' . $book->arranger_last_name . '</Surname>
            </PersonName>
		  <Telephone PhoneNumber="(' . substr($book->dial_code, 1) . ')' . $book->phone . '"/>
		  <HomeTelephone PhoneNumber="(98)23126941"/>
        <Email>' . $book->users->email . '</Email>

    </ContactPerson>
    </AirBookModifyRQ>
    <AirReservation>
        <BookingReferenceID Status="39" Instance="0" ID="' . $book->UniqueId . '" ID_Context="BookingRef"/>
    </AirReservation>
</OTA_AirBookModifyRQ>
';

        return $req;
    }


    public function test()
    {
        $req = '<OTA_AirLowFareSearchRQ xmlns="http://www.opentravel.org/OTA/2003/05"
  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:schemaLocation="http://www.opentravel.org/OTA/2003/05
  OTA_AirLowFareSearchRQ.xsd" EchoToken="50987" TimeStamp="' . date('Y-m-d\TH:i:s.uP', strtotime('now')) . '"
  Target="Production" Version="2.001" SequenceNmbr="1" PrimaryLangID="En-us">
    <POS>
        <Source AirlineVendorID="IR" ISOCountry="IR" ISOCurrency="EUR">
            <RequestorID Type="5" ID="' . $this->agent_id . '"/>
        </Source>
    </POS>
    <OriginDestinationInformation>
        <DepartureDateTime>' . '2023-6-14' . '</DepartureDateTime>
        <OriginLocation LocationCode="' . 'FRA' . '"/>
        <DestinationLocation LocationCode="' . 'IKA' . '"/>
    </OriginDestinationInformation>';
        $req .= '
    <OriginDestinationInformation>
        <DepartureDateTime>' . '2023-6-20' . '</DepartureDateTime>
        <OriginLocation LocationCode="' . 'IKA' . '"/>
        <DestinationLocation LocationCode="' . 'CDG' . '"/>
    </OriginDestinationInformation>';

        $req .= '
    <TravelPreferences >
        <CabinPref  Cabin="' . 'Economy' . '"/>
    </TravelPreferences>
    <TravelerInfoSummary>
        <AirTravelerAvail>
            <PassengerTypeQuantity Code="ADT" Quantity="' . '1' . '"/>
            <PassengerTypeQuantity Code="CHD" Quantity="' . '0' . '"/>
            <PassengerTypeQuantity Code="INF" Quantity="' . '0' . '"/>
        </AirTravelerAvail>
    </TravelerInfoSummary>
    <ProcessingInfo SearchType="' . 'STANDARD' . '"/>
</OTA_AirLowFareSearchRQ>';

        return $req;

    }


}

