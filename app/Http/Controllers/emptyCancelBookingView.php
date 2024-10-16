<?php

array:1 [ // app\Http\Controllers\Test\Booking\CancelBookingController.php:54
  "AirCancelBookingResponse" => array:1 [
    "airBookingList" => array:2 [
      "airReservation" => array:16 [
        "airItinerary" => array:2 [
          "adviceCodeSegmentExist" => "false"
          "bookOriginDestinationOptions" => ""
        ]
        "airTravelerList" => array:16 [
          "accompaniedByInfant" => "false"
          "birthDate" => "1991-08-08T00:00:00+01:00"
          "companyInfo" => ""
          "contactPerson" => array:6 [
            "email" => array:4 [
              "email" => "AAA.TEST@HITITCS.COM"
              "markedForSendingRezInfo" => "false"
              "preferred" => "false"
              "shareMarketInd" => "false"
            ]
            "personName" => array:3 [
              "givenName" => "AAA"
              "shareMarketInd" => "false"
              "surname" => "TEST"
            ]
            "phoneNumber" => array:6 [
              "areaCode" => "532"
              "countryCode" => "+90"
              "markedForSendingRezInfo" => "false"
              "preferred" => "false"
              "shareMarketInd" => "false"
              "subscriberNumber" => "1111111"
            ]
            "shareContactInfo" => "true"
            "shareMarketInd" => "false"
            "useForInvoicing" => "false"
          ]
          "documentInfoList" => array:3 [
            "birthDate" => "1991-08-08T00:00:00+01:00"
            "docHolderFormattedName" => array:3 [
              "givenName" => "AAA"
              "shareMarketInd" => "false"
              "surname" => "TEST"
            ]
            "gender" => "M"
          ]
          "emergencyContactInfo" => array:4 [
            "contactName" => array:1 [
              "shareMarketInd" => "false"
            ]
            "decline" => "false"
            "email" => array:3 [
              "markedForSendingRezInfo" => "false"
              "preferred" => "false"
              "shareMarketInd" => "false"
            ]
            "shareContactInfo" => "false"
          ]
          "gender" => "M"
          "hasStrecher" => "false"
          "parentSequence" => "-1"
          "passengerTypeCode" => "ADLT"
          "personName" => array:4 [
            "givenName" => "AAA"
            "nameTitle" => "MR"
            "shareMarketInd" => "false"
            "surname" => "TEST"
          ]
          "personNameEN" => array:4 [
            "givenName" => "AAA"
            "nameTitle" => "MR"
            "shareMarketInd" => "false"
            "surname" => "TEST"
          ]
          "requestedSeatCount" => "1"
          "shareMarketInd" => "false"
          "travelerReferenceID" => "16003691"
          "unaccompaniedMinor" => "false"
        ]
        "arrangerInfo" => array:8 [
          "agencyCode" => "SCINTILLA"
          "agencyName" => "SCINTILLA"
          "agencyType" => "AG"
          "contactInfo" => array:5 [
            "companyInfo" => array:6 [
              "cityCode" => "LOS"
              "code" => "P4"
              "codeContext" => "CRANE"
              "companyFullName" => "SCINTILLA"
              "companyShortName" => "SCINTILLA"
              "countryCode" => "NG"
            ]
            "personName" => array:2 [
              "shareMarketInd" => "false"
              "surname" => "SCINTILLA"
            ]
            "shareContactInfo" => "false"
            "shareMarketInd" => "false"
            "useForInvoicing" => "false"
          ]
          "currency" => "NGN"
          "IATANumber" => "12345678"
          "userCode" => "SC"
          "userName" => "SCINTILLA"
        ]
        "bookingReferenceIDList" => array:3 [
          "companyName" => array:6 [
            "cityCode" => "LOS"
            "code" => "P4"
            "codeContext" => "CRANE"
            "companyFullName" => "SCINTILLA"
            "companyShortName" => "SCINTILLA"
            "countryCode" => "NG"
          ]
          "ID" => "12CQ1G"
          "referenceID" => "13438378"
        ]
        "bookingType" => "R"
        "dateCreated" => "2024-10-16T10:56:10+01:00"
        "emergencyContactRequired" => "false"
        "FFPReservation" => "false"
        "groupBooking" => "false"
        "nonTicketedElementsExist" => "false"
        "pnrPaxInBlackList" => "false"
        "rlocCompleted" => "true"
        "smsSaleApplicable" => "false"
        "specialRequestDetails" => array:1 [
          "specialServiceRequestList" => array:3 [
            0 => array:8 [
              "airTravelerSequence" => "1"
              "flightSegmentSequence" => "0"
              "paymentStatus" => "FR"
              "SSR" => array:15 [
                "allowedQuantityPerPassenger" => "1"
                "bundleRelatedSsr" => "false"
                "code" => "CTCM"
                "entryDate" => "2024-10-16T10:56:10+01:00"
                "exchangeable" => "false"
                "explanation" => "90 532 1111111"
                "extraBaggage" => "false"
                "free" => "true"
                "groupCode" => "OTH"
                "groupCodeExplanation" => "OTH"
                "iciAllowed" => "false"
                "refundable" => "false"
                "showOnItinerary" => "false"
                "ssrReasonCode" => "USER_SELECTION"
                "unitOfMeasureExist" => "false"
              ]
              "serviceQuantity" => "1"
              "specialServiceReferenceId" => "30445425"
              "status" => "HK"
              "ticketed" => "false"
            ]
            1 => array:8 [
              "airTravelerSequence" => "1"
              "flightSegmentSequence" => "0"
              "paymentStatus" => "FR"
              "SSR" => array:15 [
                "allowedQuantityPerPassenger" => "1"
                "bundleRelatedSsr" => "false"
                "code" => "CTCE"
                "entryDate" => "2024-10-16T10:56:10+01:00"
                "exchangeable" => "false"
                "explanation" => "AAA.TEST@HITITCS.COM"
                "extraBaggage" => "false"
                "free" => "true"
                "groupCode" => "OTH"
                "groupCodeExplanation" => "OTH"
                "iciAllowed" => "false"
                "refundable" => "false"
                "showOnItinerary" => "false"
                "ssrReasonCode" => "USER_SELECTION"
                "unitOfMeasureExist" => "false"
              ]
              "serviceQuantity" => "1"
              "specialServiceReferenceId" => "30445426"
              "status" => "HK"
              "ticketed" => "false"
            ]
            2 => array:8 [
              "airTravelerSequence" => "1"
              "flightSegmentSequence" => "0"
              "paymentStatus" => "FR"
              "SSR" => array:15 [
                "allowedQuantityPerPassenger" => "0"
                "bundleRelatedSsr" => "false"
                "code" => "DOCS"
                "entryDate" => "2024-10-16T10:56:13+01:00"
                "exchangeable" => "false"
                "explanation" => "/////08AUG91/M//TEST/AAA"
                "extraBaggage" => "false"
                "free" => "true"
                "groupCode" => "OTH"
                "groupCodeExplanation" => "OTH"
                "iciAllowed" => "false"
                "refundable" => "false"
                "showOnItinerary" => "false"
                "ssrReasonCode" => "USER_SELECTION"
                "unitOfMeasureExist" => "false"
              ]
              "serviceQuantity" => "1"
              "specialServiceReferenceId" => "30445438"
              "status" => "HK"
              "ticketed" => "false"
            ]
          ]
        ]
        "ticketOnDeparture" => "false"
        "timeZone" => "Africa/Lagos"
      ]
      "ticketInfo" => array:4 [
        "pricingType" => "REFUND"
        "refundPaymentAmountList" => array:3 [
          "amount" => array:4 [
            "accountingSign" => "REF"
            "currency" => array:1 [
              "code" => "NGN"
            ]
            "mileAmount" => "0.0"
            "value" => "100697.0"
          ]
          "paymentCode" => "INVOICE"
          "paymentDescription" => "INV"
        ]
        "ticketItemList" => array:3 [
          0 => array:9 [
            "airTraveler" => array:13 [
              "accompaniedByInfant" => "false"
              "birthDate" => "1991-08-08T00:00:00+01:00"
              "companyInfo" => ""
              "gender" => "M"
              "hasStrecher" => "false"
              "parentSequence" => "-1"
              "passengerTypeCode" => "ADLT"
              "personName" => array:4 [
                "givenName" => "AAA"
                "nameTitle" => "MR"
                "shareMarketInd" => "false"
                "surname" => "TEST"
              ]
              "personNameEN" => array:4 [
                "givenName" => "AAA"
                "nameTitle" => "MR"
                "shareMarketInd" => "false"
                "surname" => "TEST"
              ]
              "requestedSeatCount" => "1"
              "shareMarketInd" => "false"
              "travelerReferenceID" => "16003691"
              "unaccompaniedMinor" => "false"
            ]
            "couponInfoList" => array:5 [
              "airTraveler" => array:13 [
                "accompaniedByInfant" => "false"
                "birthDate" => "1991-08-08T00:00:00+01:00"
                "companyInfo" => ""
                "gender" => "M"
                "hasStrecher" => "false"
                "parentSequence" => "-1"
                "passengerTypeCode" => "ADLT"
                "personName" => array:4 [
                  "givenName" => "AAA"
                  "nameTitle" => "MR"
                  "shareMarketInd" => "false"
                  "surname" => "TEST"
                ]
                "personNameEN" => array:4 [
                  "givenName" => "AAA"
                  "nameTitle" => "MR"
                  "shareMarketInd" => "false"
                  "surname" => "TEST"
                ]
                "requestedSeatCount" => "1"
                "shareMarketInd" => "false"
                "travelerReferenceID" => "16003691"
                "unaccompaniedMinor" => "false"
              ]
              "consumedAtIssuence" => "false"
              "couponFlightSegment" => array:11 [
                "actionCode" => "XX"
                "addOnSegment" => "false"
                "bookingClass" => array:3 [
                  "cabin" => "ECONOMY"
                  "resBookDesigCode" => "V"
                  "resBookDesigQuantity" => "0"
                ]
                "fareInfo" => array:10 [
                  "cabin" => "ECONOMY"
                  "cabinClassCode" => "Y"
                  "fareBaggageAllowance" => array:3 [
                    "allowanceType" => "WEIGHT"
                    "maxAllowedPieces" => "0"
                    "maxAllowedWeight" => array:2 [
                      "unitOfMeasureCode" => "KG"
                      "weight" => "15"
                    ]
                  ]
                  "fareGroupName" => "Eco Non Flexi Dom"
                  "fareReferenceCode" => "VOWN"
                  "fareReferenceID" => "0fe3789984dc12c1be1d8b3d18fd7120e1ac9b4adc1eda1acd89b656f157f1520d7f221747d6a889c65dbf5dc61f12bf292c7dfb142ca3a2865462e9c486404e163a332d110ce46888696dd34d0abfba948b2e3f8c05d8745fa140"
                  "fareReferenceName" => "VOWNIG"
                  "flightSegmentSequence" => "0"
                  "notValidAfter" => "2025-10-22T08:30:00+01:00"
                  "resBookDesigCode" => "V"
                ]
                "flightSegment" => array:25 [
                  "airline" => array:2 [
                    "code" => "P4"
                    "codeContext" => "IATA"
                  ]
                  "arrivalAirport" => array:6 [
                    "cityInfo" => array:2 [
                      "city" => array:3 [
                        "locationCode" => "LOS"
                        "locationName" => "Lagos"
                        "locationNameLanguage" => "EN"
                      ]
                      "country" => array:4 [
                        "locationCode" => "NG"
                        "locationName" => "Nigeria"
                        "locationNameLanguage" => "EN"
                        "currency" => array:1 [
                          "code" => "NGN"
                        ]
                      ]
                    ]
                    "codeContext" => "IATA"
                    "language" => "EN"
                    "locationCode" => "LOS"
                    "locationName" => "Lagos"
                    "timeZoneInfo" => "Africa/Lagos"
                  ]
                  "arrivalDateTime" => "2024-10-22T09:50:00+01:00"
                  "arrivalDateTimeUTC" => "2024-10-22T08:50:00+01:00"
                  "departureAirport" => array:6 [
                    "cityInfo" => array:2 [
                      "city" => array:3 [
                        "locationCode" => "ABV"
                        "locationName" => "Abuja"
                        "locationNameLanguage" => "EN"
                      ]
                      "country" => array:4 [
                        "locationCode" => "NG"
                        "locationName" => "Nigeria"
                        "locationNameLanguage" => "EN"
                        "currency" => array:1 [
                          "code" => "NGN"
                        ]
                      ]
                    ]
                    "codeContext" => "IATA"
                    "language" => "EN"
                    "locationCode" => "ABV"
                    "locationName" => "Abuja"
                    "timeZoneInfo" => "Africa/Lagos"
                  ]
                  "departureDateTime" => "2024-10-22T08:30:00+01:00"
                  "departureDateTimeUTC" => "2024-10-22T07:30:00+01:00"
                  "flightNumber" => "7121"
                  "flightSegmentID" => "1144808"
                  "ondControlled" => "false"
                  "sector" => "DOMESTIC"
                  "accumulatedDuration" => ""
                  "codeshare" => "false"
                  "distance" => "511"
                  "equipment" => array:2 [
                    "airEquipType" => "ERJ195-12C/112Y"
                    "changeofGauge" => "false"
                  ]
                  "flightNotes" => array:2 [
                    0 => array:3 [
                      "deiCode" => "504"
                      "explanation" => "Secure Flight Info"
                      "note" => "T"
                    ]
                    1 => array:3 [
                      "deiCode" => "504"
                      "explanation" => "Secure Flight Info"
                      "note" => "T"
                    ]
                  ]
                  "flownMileageQty" => "0"
                  "groundDuration" => ""
                  "iatciFlight" => "false"
                  "journeyDuration" => "PT1H20M"
                  "onTimeRate" => "0"
                  "secureFlightDataRequired" => "true"
                  "segmentStatusByFirstLeg" => "RZ"
                  "stopQuantity" => "0"
                  "trafficRestriction" => array:2 [
                    "code" => ""
                    "explanation" => ""
                  ]
                ]
                "involuntaryPermissionGiven" => "false"
                "legStatus" => "RZ"
                "referenceID" => "15861977"
                "responseCode" => "XX"
                "sequenceNumber" => "0"
                "status" => "XX"
              ]
              "cpnIsn" => "0"
              "noShow" => "false"
            ]
            "fareConstruction" => "NUC0.00END ROE"
            "inclusiveTour" => "false"
            "parentTicketNumber" => "7102400180214"
            "pricingOverview" => array:12 [
              "equivTotalAmountList" => array:4 [
                "accountingSign" => "REF"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "25200.0"
              ]
              "totalAmount" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalBaseFare" => array:4 [
                "accountingSign" => "REF"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "25200.0"
              ]
              "totalCommission" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalCommissionVat" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalDiscount" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalOtherFee" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalPenalty" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "25200.0"
              ]
              "totalServiceCharge" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalSurcharge" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalTax" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalTransactionFee" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
            ]
            "refundPricingInfo" => array:11 [
              "baseFare" => array:1 [
                "amount" => array:4 [
                  "accountingSign" => "REF"
                  "currency" => array:1 [
                    "code" => "NGN"
                  ]
                  "mileAmount" => "0.0"
                  "value" => "25200.0"
                ]
              ]
              "commissionVat" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "commissions" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "equivBaseFare" => array:4 [
                "accountingSign" => "REF"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "25200.0"
              ]
              "fareBaggageAllowance" => "0"
              "fees" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "penaltyList" => array:2 [
                0 => array:2 [
                  "amount" => array:4 [
                    "accountingSign" => "ADC"
                    "currency" => array:1 [
                      "code" => "NGN"
                    ]
                    "mileAmount" => "0.0"
                    "value" => "24966.0"
                  ]
                  "code" => "CP"
                ]
                1 => array:2 [
                  "amount" => array:4 [
                    "accountingSign" => "ADC"
                    "currency" => array:1 [
                      "code" => "NGN"
                    ]
                    "mileAmount" => "0.0"
                    "value" => "234.0"
                  ]
                  "code" => "OD"
                ]
              ]
              "surcharges" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "taxes" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => "NGN"
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "totalFare" => array:1 [
                "amount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => "NGN"
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "discountApplied" => "false"
            ]
            "serviceFee" => "0.0"
            "type" => "E_TICKET"
          ]
          1 => array:11 [
            "airTraveler" => array:13 [
              "accompaniedByInfant" => "false"
              "birthDate" => "1991-08-08T00:00:00+01:00"
              "companyInfo" => ""
              "gender" => "M"
              "hasStrecher" => "false"
              "parentSequence" => "-1"
              "passengerTypeCode" => "ADLT"
              "personName" => array:4 [
                "givenName" => "AAA"
                "nameTitle" => "MR"
                "shareMarketInd" => "false"
                "surname" => "TEST"
              ]
              "personNameEN" => array:4 [
                "givenName" => "AAA"
                "nameTitle" => "MR"
                "shareMarketInd" => "false"
                "surname" => "TEST"
              ]
              "requestedSeatCount" => "1"
              "shareMarketInd" => "false"
              "travelerReferenceID" => "16003691"
              "unaccompaniedMinor" => "false"
            ]
            "couponInfoList" => array:5 [
              "airTraveler" => array:13 [
                "accompaniedByInfant" => "false"
                "birthDate" => "1991-08-08T00:00:00+01:00"
                "companyInfo" => ""
                "gender" => "M"
                "hasStrecher" => "false"
                "parentSequence" => "-1"
                "passengerTypeCode" => "ADLT"
                "personName" => array:4 [
                  "givenName" => "AAA"
                  "nameTitle" => "MR"
                  "shareMarketInd" => "false"
                  "surname" => "TEST"
                ]
                "personNameEN" => array:4 [
                  "givenName" => "AAA"
                  "nameTitle" => "MR"
                  "shareMarketInd" => "false"
                  "surname" => "TEST"
                ]
                "requestedSeatCount" => "1"
                "shareMarketInd" => "false"
                "travelerReferenceID" => "16003691"
                "unaccompaniedMinor" => "false"
              ]
              "consumedAtIssuence" => "false"
              "couponFlightSegment" => array:11 [
                "actionCode" => "XX"
                "addOnSegment" => "false"
                "bookingClass" => array:3 [
                  "cabin" => "ECONOMY"
                  "resBookDesigCode" => "V"
                  "resBookDesigQuantity" => "0"
                ]
                "fareInfo" => array:8 [
                  "cabin" => "ECONOMY"
                  "cabinClassCode" => "Y"
                  "fareGroupName" => "Eco Non Flexi Dom"
                  "fareReferenceCode" => "VOWN"
                  "fareReferenceID" => "0fe3789984dc12c1be1d8b3d18fd7120e1ac9b4adc1eda1acd89b656f150fc500d7f221747d6a889c65dbf5dc61f12bf292c7dfb142ca3a2865462e9c486404e163a332d110ce46888696d751cbecd22f44edb8e366b4ce479715a"
                  "fareReferenceName" => "VOWNIG"
                  "flightSegmentSequence" => "0"
                  "resBookDesigCode" => "V"
                ]
                "flightSegment" => array:25 [
                  "airline" => array:2 [
                    "code" => "P4"
                    "codeContext" => "IATA"
                  ]
                  "arrivalAirport" => array:6 [
                    "cityInfo" => array:2 [
                      "city" => array:3 [
                        "locationCode" => "LOS"
                        "locationName" => "Lagos"
                        "locationNameLanguage" => "EN"
                      ]
                      "country" => array:4 [
                        "locationCode" => "NG"
                        "locationName" => "Nigeria"
                        "locationNameLanguage" => "EN"
                        "currency" => array:1 [
                          "code" => "NGN"
                        ]
                      ]
                    ]
                    "codeContext" => "IATA"
                    "language" => "EN"
                    "locationCode" => "LOS"
                    "locationName" => "Lagos"
                    "timeZoneInfo" => "Africa/Lagos"
                  ]
                  "arrivalDateTime" => "2024-10-22T09:50:00+01:00"
                  "arrivalDateTimeUTC" => "2024-10-22T08:50:00+01:00"
                  "departureAirport" => array:6 [
                    "cityInfo" => array:2 [
                      "city" => array:3 [
                        "locationCode" => "ABV"
                        "locationName" => "Abuja"
                        "locationNameLanguage" => "EN"
                      ]
                      "country" => array:4 [
                        "locationCode" => "NG"
                        "locationName" => "Nigeria"
                        "locationNameLanguage" => "EN"
                        "currency" => array:1 [
                          "code" => "NGN"
                        ]
                      ]
                    ]
                    "codeContext" => "IATA"
                    "language" => "EN"
                    "locationCode" => "ABV"
                    "locationName" => "Abuja"
                    "timeZoneInfo" => "Africa/Lagos"
                  ]
                  "departureDateTime" => "2024-10-22T08:30:00+01:00"
                  "departureDateTimeUTC" => "2024-10-22T07:30:00+01:00"
                  "flightNumber" => "7121"
                  "flightSegmentID" => "1144808"
                  "ondControlled" => "false"
                  "sector" => "DOMESTIC"
                  "accumulatedDuration" => ""
                  "codeshare" => "false"
                  "distance" => "511"
                  "equipment" => array:2 [
                    "airEquipType" => "ERJ195-12C/112Y"
                    "changeofGauge" => "false"
                  ]
                  "flightNotes" => array:2 [
                    0 => array:3 [
                      "deiCode" => "504"
                      "explanation" => "Secure Flight Info"
                      "note" => "T"
                    ]
                    1 => array:3 [
                      "deiCode" => "504"
                      "explanation" => "Secure Flight Info"
                      "note" => "T"
                    ]
                  ]
                  "flownMileageQty" => "0"
                  "groundDuration" => ""
                  "iatciFlight" => "false"
                  "journeyDuration" => "PT1H20M"
                  "onTimeRate" => "0"
                  "secureFlightDataRequired" => "true"
                  "segmentStatusByFirstLeg" => "RZ"
                  "stopQuantity" => "0"
                  "trafficRestriction" => array:2 [
                    "code" => ""
                    "explanation" => ""
                  ]
                ]
                "involuntaryPermissionGiven" => "false"
                "legStatus" => "RZ"
                "referenceID" => "15861977"
                "responseCode" => "XX"
                "sequenceNumber" => "0"
                "status" => "XX"
              ]
              "cpnIsn" => "0"
              "noShow" => "false"
            ]
            "fareConstruction" => "NUC0.00END ROE"
            "inclusiveTour" => "false"
            "pricingOverview" => array:12 [
              "equivTotalAmountList" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalAmount" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalBaseFare" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalCommission" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalCommissionVat" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalDiscount" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalOtherFee" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalPenalty" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalServiceCharge" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalSurcharge" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalTax" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalTransactionFee" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
            ]
            "reasonForIssuance" => array:3 [
              "explanation" => "INSU-TRAVEL INSURANCE"
              "reasonForIssuanceCode" => "D"
              "reasonForIssuanceSubCode" => "0BG"
            ]
            "refundPricingInfo" => array:10 [
              "baseFare" => array:1 [
                "amount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => "NGN"
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "commissionVat" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "commissions" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "equivBaseFare" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "fareBaggageAllowance" => "0"
              "fees" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "surcharges" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "taxes" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => "NGN"
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "totalFare" => array:1 [
                "amount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => "NGN"
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "discountApplied" => "false"
            ]
            "serviceFee" => "0.0"
            "specialServiceRequest" => array:14 [
              "allowedQuantityPerPassenger" => "0"
              "bundleRelatedSsr" => "false"
              "code" => "INSU"
              "exchangeable" => "false"
              "explanation" => "INSU-TRAVEL INSURANCE"
              "extraBaggage" => "false"
              "free" => "false"
              "groupCode" => "INSU"
              "groupCodeExplanation" => "INSU"
              "iciAllowed" => "false"
              "refundable" => "false"
              "showOnItinerary" => "false"
              "specialServiceReferenceId" => "30445429"
              "unitOfMeasureExist" => "false"
            ]
            "ticketDocumentNbr" => "7104200061612"
            "type" => "MCO"
          ]
          2 => array:11 [
            "airTraveler" => array:13 [
              "accompaniedByInfant" => "false"
              "birthDate" => "1991-08-08T00:00:00+01:00"
              "companyInfo" => ""
              "gender" => "M"
              "hasStrecher" => "false"
              "parentSequence" => "-1"
              "passengerTypeCode" => "ADLT"
              "personName" => array:4 [
                "givenName" => "AAA"
                "nameTitle" => "MR"
                "shareMarketInd" => "false"
                "surname" => "TEST"
              ]
              "personNameEN" => array:4 [
                "givenName" => "AAA"
                "nameTitle" => "MR"
                "shareMarketInd" => "false"
                "surname" => "TEST"
              ]
              "requestedSeatCount" => "1"
              "shareMarketInd" => "false"
              "travelerReferenceID" => "16003691"
              "unaccompaniedMinor" => "false"
            ]
            "couponInfoList" => array:5 [
              "airTraveler" => array:13 [
                "accompaniedByInfant" => "false"
                "birthDate" => "1991-08-08T00:00:00+01:00"
                "companyInfo" => ""
                "gender" => "M"
                "hasStrecher" => "false"
                "parentSequence" => "-1"
                "passengerTypeCode" => "ADLT"
                "personName" => array:4 [
                  "givenName" => "AAA"
                  "nameTitle" => "MR"
                  "shareMarketInd" => "false"
                  "surname" => "TEST"
                ]
                "personNameEN" => array:4 [
                  "givenName" => "AAA"
                  "nameTitle" => "MR"
                  "shareMarketInd" => "false"
                  "surname" => "TEST"
                ]
                "requestedSeatCount" => "1"
                "shareMarketInd" => "false"
                "travelerReferenceID" => "16003691"
                "unaccompaniedMinor" => "false"
              ]
              "consumedAtIssuence" => "false"
              "couponFlightSegment" => array:11 [
                "actionCode" => "XX"
                "addOnSegment" => "false"
                "bookingClass" => array:3 [
                  "cabin" => "ECONOMY"
                  "resBookDesigCode" => "V"
                  "resBookDesigQuantity" => "0"
                ]
                "fareInfo" => array:8 [
                  "cabin" => "ECONOMY"
                  "cabinClassCode" => "Y"
                  "fareGroupName" => "Eco Non Flexi Dom"
                  "fareReferenceCode" => "VOWN"
                  "fareReferenceID" => "0fe3789984dc12c1be1d8b3d18fd7120e1ac9b4adc1eda1acd89b656f153f35c0d7f221747d6a889c65dbf5dc61f12bf292c7dfb142ca3a2865462e9c486404e163a332d110ce46888696dbeeeb91d2037fc5af4959e2b578f9f7f"
                  "fareReferenceName" => "VOWNIG"
                  "flightSegmentSequence" => "0"
                  "resBookDesigCode" => "V"
                ]
                "flightSegment" => array:25 [
                  "airline" => array:2 [
                    "code" => "P4"
                    "codeContext" => "IATA"
                  ]
                  "arrivalAirport" => array:6 [
                    "cityInfo" => array:2 [
                      "city" => array:3 [
                        "locationCode" => "LOS"
                        "locationName" => "Lagos"
                        "locationNameLanguage" => "EN"
                      ]
                      "country" => array:4 [
                        "locationCode" => "NG"
                        "locationName" => "Nigeria"
                        "locationNameLanguage" => "EN"
                        "currency" => array:1 [
                          "code" => "NGN"
                        ]
                      ]
                    ]
                    "codeContext" => "IATA"
                    "language" => "EN"
                    "locationCode" => "LOS"
                    "locationName" => "Lagos"
                    "timeZoneInfo" => "Africa/Lagos"
                  ]
                  "arrivalDateTime" => "2024-10-22T09:50:00+01:00"
                  "arrivalDateTimeUTC" => "2024-10-22T08:50:00+01:00"
                  "departureAirport" => array:6 [
                    "cityInfo" => array:2 [
                      "city" => array:3 [
                        "locationCode" => "ABV"
                        "locationName" => "Abuja"
                        "locationNameLanguage" => "EN"
                      ]
                      "country" => array:4 [
                        "locationCode" => "NG"
                        "locationName" => "Nigeria"
                        "locationNameLanguage" => "EN"
                        "currency" => array:1 [
                          "code" => "NGN"
                        ]
                      ]
                    ]
                    "codeContext" => "IATA"
                    "language" => "EN"
                    "locationCode" => "ABV"
                    "locationName" => "Abuja"
                    "timeZoneInfo" => "Africa/Lagos"
                  ]
                  "departureDateTime" => "2024-10-22T08:30:00+01:00"
                  "departureDateTimeUTC" => "2024-10-22T07:30:00+01:00"
                  "flightNumber" => "7121"
                  "flightSegmentID" => "1144808"
                  "ondControlled" => "false"
                  "sector" => "DOMESTIC"
                  "accumulatedDuration" => ""
                  "codeshare" => "false"
                  "distance" => "511"
                  "equipment" => array:2 [
                    "airEquipType" => "ERJ195-12C/112Y"
                    "changeofGauge" => "false"
                  ]
                  "flightNotes" => array:2 [
                    0 => array:3 [
                      "deiCode" => "504"
                      "explanation" => "Secure Flight Info"
                      "note" => "T"
                    ]
                    1 => array:3 [
                      "deiCode" => "504"
                      "explanation" => "Secure Flight Info"
                      "note" => "T"
                    ]
                  ]
                  "flownMileageQty" => "0"
                  "groundDuration" => ""
                  "iatciFlight" => "false"
                  "journeyDuration" => "PT1H20M"
                  "onTimeRate" => "0"
                  "secureFlightDataRequired" => "true"
                  "segmentStatusByFirstLeg" => "RZ"
                  "stopQuantity" => "0"
                  "trafficRestriction" => array:2 [
                    "code" => ""
                    "explanation" => ""
                  ]
                ]
                "involuntaryPermissionGiven" => "false"
                "legStatus" => "RZ"
                "referenceID" => "15861977"
                "responseCode" => "XX"
                "sequenceNumber" => "0"
                "status" => "XX"
              ]
              "cpnIsn" => "0"
              "noShow" => "false"
            ]
            "fareConstruction" => "NUC0.00END ROE"
            "inclusiveTour" => "false"
            "pricingOverview" => array:12 [
              "equivTotalAmountList" => array:4 [
                "accountingSign" => "REF"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "100697.0"
              ]
              "totalAmount" => array:4 [
                "accountingSign" => "REF"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "100697.0"
              ]
              "totalBaseFare" => array:4 [
                "accountingSign" => "REF"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "100697.0"
              ]
              "totalCommission" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalCommissionVat" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalDiscount" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalOtherFee" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalPenalty" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalServiceCharge" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalSurcharge" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalTax" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
              "totalTransactionFee" => array:4 [
                "accountingSign" => "ADC"
                "currency" => array:1 [
                  "code" => ""
                ]
                "mileAmount" => "0.0"
                "value" => "0.0"
              ]
            ]
            "reasonForIssuance" => array:3 [
              "explanation" => "LITHIUM BATTERY WHEELCHAIR"
              "reasonForIssuanceCode" => "E"
              "reasonForIssuanceSubCode" => "0WL"
            ]
            "refundPricingInfo" => array:10 [
              "baseFare" => array:1 [
                "amount" => array:4 [
                  "accountingSign" => "REF"
                  "currency" => array:1 [
                    "code" => "NGN"
                  ]
                  "mileAmount" => "0.0"
                  "value" => "100697.0"
                ]
              ]
              "commissionVat" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "commissions" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "equivBaseFare" => array:4 [
                "accountingSign" => "REF"
                "currency" => array:1 [
                  "code" => "NGN"
                ]
                "mileAmount" => "0.0"
                "value" => "100697.0"
              ]
              "fareBaggageAllowance" => "0"
              "fees" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "surcharges" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => ""
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "taxes" => array:1 [
                "totalAmount" => array:4 [
                  "accountingSign" => "ADC"
                  "currency" => array:1 [
                    "code" => "NGN"
                  ]
                  "mileAmount" => "0.0"
                  "value" => "0.0"
                ]
              ]
              "totalFare" => array:1 [
                "amount" => array:4 [
                  "accountingSign" => "REF"
                  "currency" => array:1 [
                    "code" => "NGN"
                  ]
                  "mileAmount" => "0.0"
                  "value" => "100697.0"
                ]
              ]
              "discountApplied" => "false"
            ]
            "serviceFee" => "0.0"
            "specialServiceRequest" => array:14 [
              "allowedQuantityPerPassenger" => "0"
              "bundleRelatedSsr" => "false"
              "code" => "WCLB"
              "exchangeable" => "false"
              "explanation" => "WCLB LITHIUM BATTERY WHEELCHAIR"
              "extraBaggage" => "false"
              "free" => "false"
              "groupCode" => "WCH"
              "groupCodeExplanation" => "WCH"
              "iciAllowed" => "false"
              "refundable" => "false"
              "showOnItinerary" => "false"
              "specialServiceReferenceId" => "30445434"
              "unitOfMeasureExist" => "false"
            ]
            "ticketDocumentNbr" => "7104200061611"
            "type" => "MCO"
          ]
        ]
        "totalAmount" => array:4 [
          "accountingSign" => "REF"
          "currency" => array:1 [
            "code" => "NGN"
          ]
          "mileAmount" => "0.0"
          "value" => "100697.0"
        ]
      ]
    ]
  ]
]