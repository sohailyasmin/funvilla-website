<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>
    <style type="text/css"> 
        * {
            margin:0; padding:0; text-indent:0; 
        }
        h1 { 
            color: black; font-family:Arial, sans-serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 15pt; 
        }
        p { 
            color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 12pt; margin:0pt; 
        }
        h2 { 
            color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: bold; text-decoration: none; font-size: 12pt; 
        }
        .a { 
            color: black; font-family:"Times New Roman", serif; font-style: normal; font-weight: normal; text-decoration: none; font-size: 12pt; 
        }
        .page-break {
            page-break-after: always;
        }
        .center {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div style="padding: 20pt;">
    <p style="text-indent: 0pt;text-align: left;"><br/></p>
    <p style="text-indent: 0pt;text-align: left;">
        <span>
            <table class="center">
                <tr>
                    <td>
                        <img width="113" height="98" src="{{asset('images/funvilla.png')}}"/>
                    </td>
                </tr>
            </table>
        </span>
    </p>
    <h1 style="text-align: center; padding-top:4pt; padding-bottom:4pt;" >
        FUNVILLA INDOOR PLAYGROUND AND TRAMPOLINE PARK
    </h1>
    <p style="text-indent: 0pt;text-align: left;"><br/></p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: left;">
        FUNVILLA WAIVER
    </p>
    <p style="text-indent: 0pt;text-align: left;"><br/></p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: left;">
        PLEASE READ WITH FULL ATTENTION!
    </p>
    <p style="text-indent: 0pt;text-align: left;"><br/></p>
    <p style="text-indent: 0pt;text-align: left;"><br/></p>
    <div style="padding-left: 5pt;text-indent: 0pt;text-align: left;">
        {!! $data['snapshot']['tc_text'] ?? '' !!}
    </div>
    <p style="text-indent: 0pt;text-align: left;"><br/></p>
    <p style="padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
        Parent/Legal Guardian Name: {{($data['snapshot']['customer_first_name'] ?? '') . ' '. ($data['snapshot']['customer_last_name'] ?? '')}}
    </p>
    @php $customerSignature = !empty($signature_data) ? Arr::first($signature_data, function ($value, $key) { return $value['family_member_type'] == 'customer';}) : []; @endphp
    @if(is_array($customerSignature) && isset($customerSignature['signature_snapshot']))
    <p style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
        Parent/Legal Guardian Sign:
    </p>
    <div style="padding-left: 5pt;text-indent: 0pt;">
        <img width="100%" height="98" src="{{$customerSignature['signature_snapshot']}}"/>
    </div>
    @endif
    </div>
    {{-- <div style="padding: 20pt;">
    <p style="text-indent: 0pt;text-align: left;"><br/></p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: left;">
        PARENT&#39;S OR LEGAL GUARDIAN&#39;S ADDITIONAL AGREEMENT AND INDEMNIFICATION (Must
    </p>
    <p style="padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
        be completed for participants under the age of 18)
    </p>
    @foreach($data['snapshot']['family_member'] ?? [] as $familyMember)
        @if($familyMember['type'] == 'infants')
            <p style="padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
                Minor Name: {{($familyMember['first_name'] ?? '') . ' '. ($familyMember['last_name'] ?? '')}}
            </p>
        @endif
    @endforeach
    <p style="text-indent: 0pt;text-align: left;"><br/></p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: left;">
        The above-mentioned minor MINOR being permitted to enter and participate in Funvilla Indoor Playground and Trampoline Park activities either by using equipment or visit only. I-the signing Parent/Legal Guardian agree on behalf of the MINOR to the above-mentioned assumptions of risk, release of liability and waiver of claims. I release, indemnify and hold harmless 2621860 Ontario Ltd (operating as Funvilla) and Funvilla from all claims which are brought by, or on behalf of the MINOR, and which are in any way connected with such contract or use by the Minor. I confirm and certify that I am the parent/ legal guardian of the above-mentioned MINOR and /or I have the power of attorney to sign this contract on behalf of the parent or legal guardian of the MINOR. By signing this document, I authorize the MINOR to enter and participation
    </p> 
    </div> --}}
    <div style="padding: 20pt; page-break-before: always;">
    <p style="text-indent: 0pt;text-align: left;"><br/></p>
    <h1 style="padding-top: 4pt;text-indent: 0pt;text-align: center;">
        Signing Details
    </h1>
    <p style="text-indent: 0pt;text-align: left;"><br/></p>
    <p style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
        Waiver Document ID: {{$data['title']}} {{--W90656D20230923--}}
    </p>
    <p style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
        Date &amp; Time: {{Carbon\Carbon::parse($data['created_at'])->timezone('America/Toronto')->toDayDateTimeString()}} {{--23-Sep-2023 23:12 (EST)--}}
    </p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: left;line-height: 204%;">
        The following signing persons digitally agreed to this document.
    </p>
    <h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;line-height: 204%;">
        Signing Authority
    </h2>
    <p style="padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
        {{($data['snapshot']['customer_first_name'] ?? '') .' '. ($data['snapshot']['customer_last_name'] ?? '')}}
    </p>
    <p style="padding-left: 5pt;text-indent: 0pt;text-align: left;line-height: 204%;">
        Address: {{$data['snapshot']['customer_address'] ?? ''}}
    </p>
    <p style="padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
        <a href="mailto:s.u.hussnain@gmail.ca" class="a" target="_blank">
            Email Address: {{$data['snapshot']['customer_email'] ?? ''}}
        </a>
    </p>
    <p style="padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
        <a href="javascript" class="a" target="_blank">
            Phone Number: {{$data['snapshot']['customer_phone'] ?? ''}}
        </a>
    </p>
    <h2 style="padding-left: 5pt;text-indent: 0pt;text-align: left;line-height: 204%;">
        Included Family Members Children/Adults/Minors
    </h2>
    @foreach($data['snapshot']['family_member'] ?? [] as $familyMember)
        @if($familyMember['type'] != 'customer')
            <p style="padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
                {{($familyMember['first_name'] ?? '') . ' '. ($familyMember['last_name'] ?? '')}}, @if(isset($familyMember['dob']) && !empty($familyMember['dob'])) Age: {{\Carbon\Carbon::parse($familyMember['dob'])->diff(\Carbon\Carbon::now())->format('%y years');}} old @endif
            </p>
            @if($familyMember['type'] == 'adult' && is_array($signature_data) && isset($signature_data[$familyMember['id']]))
            <p style="padding-top: 4pt;padding-left: 5pt;text-indent: 0pt;line-height: 204%;text-align: left;">
                Sign:
            </p>
            <div style="padding-left: 5pt;">
                <img width="100%" height="98" src="{{$signature_data[$familyMember['id']]['signature_snapshot']}}"/>
            </div>
            @endif
        @endif
    @endforeach
    </div>
</body>
</html>