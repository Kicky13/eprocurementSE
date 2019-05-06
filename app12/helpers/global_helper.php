<?php

if (!function_exists('echopre')) {

    function echopre($dt) {
        echo'<pre>';
        print_r($dt);
        echo'</pre>';
    }

}

if (!function_exists('get_mail')) {

    function get_mail() {
        $ci =& get_instance();
        $email = $ci->db->where('active','1')->get('m_mail_setting')->row();
        $dt['email']      = $email->email_address;
        $dt['password']   = $email->email_password;
        $dt['smtp']       = $email->smtp;
        $dt['port']       = $email->port;
        $dt['protocol']    = $email->protocol;
        $dt['crypto'] = $email->crypto;

        /*
        $dt['email']      = 'satu3885@gmail.com';
        $dt['password']   = 'satudua12';
        $dt['smtp']       = 'smtp.gmail.com';
        $dt['port']       = '465';
        $dt['protocol']    = 'smtp';
        $dt['crypto'] = 'ssl';

        $dt['email']      = 'no-reply.scm@supreme-energy.com';
        $dt['password']   = 'printer';
        $dt['smtp']       = 'mail.supreme-energy.com';
        $dt['port']       = '25';
        $dt['protocol']    = 'mail';
        $dt['smtp_crypto'] = '';*/
        return $dt;
    }

}

if (!function_exists('echoall')) {

    function echoall($dt) {
        print_r($dt);
    }

}

if (!function_exists('areatext')) {

    function areatext($id, $dt, $lbl_idn, $lbl_eng) {
        return"<div class='form-group col-12'>"
                . "<label class='label-control' for='" . $id . "'><span class='IDN'>" . $lbl_idn . "</span><span class='ENG'>" . $lbl_eng . "</span></label>"
                . "<textarea id='" . $id . "' name='" . $id . "' class='form-control required' rows='5'>" . $dt . "</textarea>"
                . "</div>";
    }

}

if (!function_exists('areacsms')) {

    function areacsms($id, $dt, $lbl_idn, $lbl_eng) {
        return"<div class='form-group col-12'>"
                . "<label class='label-control' for='" . $id . "'><span class='IDN'>" . $lbl_idn . "</span><span class='ENG'>" . $lbl_eng . "</span></label>"
                . "<textarea id='" . $id . "' name='" . $id . "' class='form-control required' rows='5'>" . $dt . "</textarea>"
                . "</div>";
    }

}

if (!function_exists('lang')) {

    function lang($ind, $eng) {
        return "<span class='IDN' >$ind</span><span class='ENG' >$eng</span>";
    }

}
if (!function_exists('langoption')) {

    function langoption($ind, $eng, $select = false) {
        if ($select == true)
            return "<option class='IDN' value='$ind' selected>$ind</option><option class='ENG' value='$ind' selected>$eng</option>";
        else
            return "<option class='IDN' value='$ind'>$ind</option><option class='ENG' value='$ind'>$eng</option>";
    }

}
if (!function_exists('opprovinsi')) {

    function opprovinsi() {
        return '
            <optgroup label="Sumatra">
                <option value="Nanggro Aceh Darussalam"> Nanggro Aceh Darussalam</option>
                <option value="Sumatra Utara">Sumatra Utara </option>
                <option value="Sumatra Selatan">Sumatra Selatan </option>
                <option value="Sumatra Barat">Sumatra Barat</option>
                <option value="Bengkulu">Bengkulu </option>
                <option value="Riau">Riau </option>
                <option value="Kepulauan Riau">Kepulauan Riau</option>
                <option value="Jambi">Jambi</option>
                <option value="Lampung">Lampung</option>
                <option value="Bangka Belitung">Bangka Belitung</option>
            </optgroup>
            <optgroup label="Kalimantan"></option>
                <option value="Kalimantan Barat">Kalimantan Barat</option>
                <option value="Kalimantan Timur">Kalimantan Timur</option>
                <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                <option value="Kalimantan Tengah">Kalimantan Tengah </option>
                <option value="Kalimantan Utara">Kalimantan Utara </option>
            </optgroup>
            <optgroup label="Jawa">
                <option value="Banten">Banten</option>
                <option value="DKI Jakarta">DKI Jakarta</option>
                <option value="Jawa Barat">Jawa Barat</option>
                <option value="Jawa Tengah">Jawa Tengah</option>
                <option value="Yogyakarta">Yogyakarta</option>
                <option value="Jawa Timur">Jawa Timur</option>
            </optgroup>
            <optgroup label="NTT dan Bali">
                <option value="Bali">Bali</option>
                <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
            </optgroup>
            <optgroup label="Sulawesi">
                <option value="Gorontalo">Gorontalo</option>
                <option value="Sulawesi Barat">Sulawesi Barat</option>
                <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                <option value="Sulawesi Utara">Sulawesi Utara</option>
                <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                <option value="Sulawesi Selatan">Sulawesi Selatan</option>
            </optgroup>
                <optgroup label="Maluku">
                <option value="Maluku Utara">Maluku Utara</option>
                <option value="Maluku">Maluku</option>
            </optgroup>
            <optgroup label="Papua">
                <option value="Papua">Papua</option>
                <option value="Papua Barat">Papua Barat</option>
            </optgroup>
        ';
    }

}
if (!function_exists('opcountry')) {

    function opcountry() {
      return '<optgroup label="Default Country">
          <option value="ID"  data-code="62">Indonesia (+62)</option>
          <optgroup label="Others">
          <option value="DZ"  data-code="213">Algeria (+213)</option>
          <option value="AD"  data-code="376">Andorra (+376)</option>
          <option value="AO"  data-code="244">Angola (+244)</option>
          <option value="AI"  data-code="1264">Anguilla (+1264)</option>
          <option value="AG"  data-code="1268">Antigua &amp; Barbuda (+1268)</option>
          <option value="AR"  data-code="54">Argentina (+54)</option>
          <option value="AM"  data-code="374">Armenia (+374)</option>
          <option value="AW"  data-code="297">Aruba (+297)</option>
          <option value="AU"  data-code="61">Australia (+61)</option>
          <option value="AT"  data-code="43">Austria (+43)</option>
          <option value="AZ"  data-code="994">Azerbaijan (+994)</option>
          <option value="BS"  data-code="1242">Bahamas (+1242)</option>
          <option value="BH"  data-code="973">Bahrain (+973)</option>
          <option value="BD"  data-code="880">Bangladesh (+880)</option>
          <option value="BB"  data-code="1246">Barbados (+1246)</option>
          <option value="BY"  data-code="375">Belarus (+375)</option>
          <option value="BE"  data-code="32">Belgium (+32)</option>
          <option value="BZ"  data-code="501">Belize (+501)</option>
          <option value="BJ"  data-code="229">Benin (+229)</option>
          <option value="BM"  data-code="1441">Bermuda (+1441)</option>
          <option value="BT"  data-code="975">Bhutan (+975)</option>
          <option value="BO"  data-code="591">Bolivia (+591)</option>
          <option value="BA"  data-code="387">Bosnia Herzegovina (+387)</option>
          <option value="BW"  data-code="267">Botswana (+267)</option>
          <option value="BR"  data-code="55">Brazil (+55)</option>
          <option value="BN"  data-code="673">Brunei (+673)</option>
          <option value="BG"  data-code="359">Bulgaria (+359)</option>
          <option value="BF"  data-code="226">Burkina Faso (+226)</option>
          <option value="BI"  data-code="257">Burundi (+257)</option>
          <option value="KH"  data-code="855">Cambodia (+855)</option>
          <option value="CM"  data-code="237">Cameroon (+237)</option>
          <option value="CA"  data-code="1">Canada (+1)</option>
          <option value="CV"  data-code="238">Cape Verde Islands (+238)</option>
          <option value="KY"  data-code="1345">Cayman Islands (+1345)</option>
          <option value="CF"  data-code="236">Central African Republic (+236)</option>
          <option value="CL"  data-code="56">Chile (+56)</option>
          <option value="CN"  data-code="86">China (+86)</option>
          <option value="CO"  data-code="57">Colombia (+57)</option>
          <option value="KM"  data-code="269">Comoros (+269)</option>
          <option value="CG"  data-code="242">Congo (+242)</option>
          <option value="CK"  data-code="682">Cook Islands (+682)</option>
          <option value="CR"  data-code="506">Costa Rica (+506)</option>
          <option value="HR"  data-code="385">Croatia (+385)</option>
          <option value="CU"  data-code="53">Cuba (+53)</option>
          <option value="CY"  data-code="90392">Cyprus North (+90392)</option>
          <option value="CY"  data-code="357">Cyprus South (+357)</option>
          <option value="CZ"  data-code="42">Czech Republic (+42)</option>
          <option value="DK"  data-code="45">Denmark (+45)</option>
          <option value="DJ"  data-code="253">Djibouti (+253)</option>
          <option value="DM"  data-code="1809">Dominica (+1809)</option>
          <option value="DO"  data-code="1809">Dominican Republic (+1809)</option>
          <option value="EC"  data-code="593">Ecuador (+593)</option>
          <option value="EG"  data-code="20">Egypt (+20)</option>
          <option value="SV"  data-code="503">El Salvador (+503)</option>
          <option value="GQ"  data-code="240">Equatorial Guinea (+240)</option>
          <option value="ER"  data-code="291">Eritrea (+291)</option>
          <option value="EE"  data-code="372">Estonia (+372)</option>
          <option value="ET"  data-code="251">Ethiopia (+251)</option>
          <option value="FK"  data-code="500">Falkland Islands (+500)</option>
          <option value="FO"  data-code="298">Faroe Islands (+298)</option>
          <option value="FJ"  data-code="679">Fiji (+679)</option>
          <option value="FI"  data-code="358">Finland (+358)</option>
          <option value="FR"  data-code="33">France (+33)</option>
          <option value="GF"  data-code="594">French Guiana (+594)</option>
          <option value="PF"  data-code="689">French Polynesia (+689)</option>
          <option value="GA"  data-code="241">Gabon (+241)</option>
          <option value="GM"  data-code="220">Gambia (+220)</option>
          <option value="GE"  data-code="7880">Georgia (+7880)</option>
          <option value="DE"  data-code="49">Germany (+49)</option>
          <option value="GH"  data-code="233">Ghana (+233)</option>
          <option value="GI"  data-code="350">Gibraltar (+350)</option>
          <option value="GR"  data-code="30">Greece (+30)</option>
          <option value="GL"  data-code="299">Greenland (+299)</option>
          <option value="GD"  data-code="1473">Grenada (+1473)</option>
          <option value="GP"  data-code="590">Guadeloupe (+590)</option>
          <option value="GU"  data-code="671">Guam (+671)</option>
          <option value="GT"  data-code="502">Guatemala (+502)</option>
          <option value="GN"  data-code="224">Guinea (+224)</option>
          <option value="GW"  data-code="245">Guinea - Bissau (+245)</option>
          <option value="GY"  data-code="592">Guyana (+592)</option>
          <option value="HT"  data-code="509">Haiti (+509)</option>
          <option value="HN"  data-code="504">Honduras (+504)</option>
          <option value="HK"  data-code="852">Hong Kong (+852)</option>
          <option value="HU"  data-code="36">Hungary (+36)</option>
          <option value="IS"  data-code="354">Iceland (+354)</option>
          <option value="IN"  data-code="91">India (+91)</option>
          <option value="ID"  data-code="62">Indonesia (+62)</option>
          <option value="IR"  data-code="98">Iran (+98)</option>
          <option value="IQ"  data-code="964">Iraq (+964)</option>
          <option value="IE"  data-code="353">Ireland (+353)</option>
          <option value="IL"  data-code="972">Israel (+972)</option>
          <option value="IT"  data-code="39">Italy (+39)</option>
          <option value="JM"  data-code="1876">Jamaica (+1876)</option>
          <option value="JP"  data-code="81">Japan (+81)</option>
          <option value="JO"  data-code="962">Jordan (+962)</option>
          <option value="KZ"  data-code="7">Kazakhstan (+7)</option>
          <option value="KE"  data-code="254">Kenya (+254)</option>
          <option value="KI"  data-code="686">Kiribati (+686)</option>
          <option value="KP"  data-code="850">Korea North (+850)</option>
          <option value="KR"  data-code="82">Korea South (+82)</option>
          <option value="KW"  data-code="965">Kuwait (+965)</option>
          <option value="KG"  data-code="996">Kyrgyzstan (+996)</option>
          <option value="LA"  data-code="856">Laos (+856)</option>
          <option value="LV"  data-code="371">Latvia (+371)</option>
          <option value="LB"  data-code="961">Lebanon (+961)</option>
          <option value="LS"  data-code="266">Lesotho (+266)</option>
          <option value="LR"  data-code="231">Liberia (+231)</option>
          <option value="LY"  data-code="218">Libya (+218)</option>
          <option value="LI"  data-code="417">Liechtenstein (+417)</option>
          <option value="LT"  data-code="370">Lithuania (+370)</option>
          <option value="LU"  data-code="352">Luxembourg (+352)</option>
          <option value="MO"  data-code="853">Macao (+853)</option>
          <option value="MK"  data-code="389">Macedonia (+389)</option>
          <option value="MG"  data-code="261">Madagascar (+261)</option>
          <option value="MW"  data-code="265">Malawi (+265)</option>
          <option value="MY"  data-code="60">Malaysia (+60)</option>
          <option value="MV"  data-code="960">Maldives (+960)</option>
          <option value="ML"  data-code="223">Mali (+223)</option>
          <option value="MT"  data-code="356">Malta (+356)</option>
          <option value="MH"  data-code="692">Marshall Islands (+692)</option>
          <option value="MQ"  data-code="596">Martinique (+596)</option>
          <option value="MR"  data-code="222">Mauritania (+222)</option>
          <option value="YT"  data-code="269">Mayotte (+269)</option>
          <option value="MX"  data-code="52">Mexico (+52)</option>
          <option value="FM"  data-code="691">Micronesia (+691)</option>
          <option value="MD"  data-code="373">Moldova (+373)</option>
          <option value="MC"  data-code="377">Monaco (+377)</option>
          <option value="MN"  data-code="976">Mongolia (+976)</option>
          <option value="MS"  data-code="1664">Montserrat (+1664)</option>
          <option value="MA"  data-code="212">Morocco (+212)</option>
          <option value="MZ"  data-code="258">Mozambique (+258)</option>
          <option value="MN"  data-code="95">Myanmar (+95)</option>
          <option value="NA"  data-code="264">Namibia (+264)</option>
          <option value="NR"  data-code="674">Nauru (+674)</option>
          <option value="NP"  data-code="977">Nepal (+977)</option>
          <option value="NL"  data-code="31">Netherlands (+31)</option>
          <option value="NC"  data-code="687">New Caledonia (+687)</option>
          <option value="NZ"  data-code="64">New Zealand (+64)</option>
          <option value="NI"  data-code="505">Nicaragua (+505)</option>
          <option value="NE"  data-code="227">Niger (+227)</option>
          <option value="NG"  data-code="234">Nigeria (+234)</option>
          <option value="NU"  data-code="683">Niue (+683)</option>
          <option value="NF"  data-code="672">Norfolk Islands (+672)</option>
          <option value="NP"  data-code="670">Northern Marianas (+670)</option>
          <option value="NO"  data-code="47">Norway (+47)</option>
          <option value="OM"  data-code="968">Oman (+968)</option>
          <option value="PW"  data-code="680">Palau (+680)</option>
          <option value="PA"  data-code="507">Panama (+507)</option>
          <option value="PG"  data-code="675">Papua New Guinea (+675)</option>
          <option value="PY"  data-code="595">Paraguay (+595)</option>
          <option value="PE"  data-code="51">Peru (+51)</option>
          <option value="PH"  data-code="63">Philippines (+63)</option>
          <option value="PL"  data-code="48">Poland (+48)</option>
          <option value="PT"  data-code="351">Portugal (+351)</option>
          <option value="PR"  data-code="1787">Puerto Rico (+1787)</option>
          <option value="QA"  data-code="974">Qatar (+974)</option>
          <option value="RE"  data-code="262">Reunion (+262)</option>
          <option value="RO"  data-code="40">Romania (+40)</option>
          <option value="RU"  data-code="7">Russia (+7)</option>
          <option value="RW"  data-code="250">Rwanda (+250)</option>
          <option value="SM"  data-code="378">San Marino (+378)</option>
          <option value="ST"  data-code="239">Sao Tome &amp; Principe (+239)</option>
          <option value="SA"  data-code="966">Saudi Arabia (+966)</option>
          <option value="SN"  data-code="221">Senegal (+221)</option>
          <option value="CS"  data-code="381">Serbia (+381)</option>
          <option value="SC"  data-code="248">Seychelles (+248)</option>
          <option value="SL"  data-code="232">Sierra Leone (+232)</option>
          <option value="SG"  data-code="65">Singapore (+65)</option>
          <option value="SK"  data-code="421">Slovak Republic (+421)</option>
          <option value="SI"  data-code="386">Slovenia (+386)</option>
          <option value="SB"  data-code="677">Solomon Islands (+677)</option>
          <option value="SO"  data-code="252">Somalia (+252)</option>
          <option value="ZA"  data-code="27">South Africa (+27)</option>
          <option value="ES"  data-code="34">Spain (+34)</option>
          <option value="LK"  data-code="94">Sri Lanka (+94)</option>
          <option value="SH"  data-code="290">St. Helena (+290)</option>
          <option value="KN"  data-code="1869">St. Kitts (+1869)</option>
          <option value="SC"  data-code="1758">St. Lucia (+1758)</option>
          <option value="SD"  data-code="249">Sudan (+249)</option>
          <option value="SR"  data-code="597">Suriname (+597)</option>
          <option value="SZ"  data-code="268">Swaziland (+268)</option>
          <option value="SE"  data-code="46">Sweden (+46)</option>
          <option value="CH"  data-code="41">Switzerland (+41)</option>
          <option value="SI"  data-code="963">Syria (+963)</option>
          <option value="TW"  data-code="886">Taiwan (+886)</option>
          <option value="TJ"  data-code="7">Tajikstan (+7)</option>
          <option value="TH"  data-code="66">Thailand (+66)</option>
          <option value="TG"  data-code="228">Togo (+228)</option>
          <option value="TO"  data-code="676">Tonga (+676)</option>
          <option value="TT"  data-code="1868">Trinidad &amp; Tobago (+1868)</option>
          <option value="TN"  data-code="216">Tunisia (+216)</option>
          <option value="TR"  data-code="90">Turkey (+90)</option>
          <option value="TM"  data-code="7">Turkmenistan (+7)</option>
          <option value="TM"  data-code="993">Turkmenistan (+993)</option>
          <option value="TC"  data-code="1649">Turks &amp; Caicos Islands (+1649)</option>
          <option value="TV"  data-code="688">Tuvalu (+688)</option>
          <option value="UG"  data-code="256">Uganda (+256)</option>
          <option value="GB"  data-code="44">UK (+44)</option>
          <option value="UA"  data-code="380">Ukraine (+380)</option>
          <option value="AE"  data-code="971">United Arab Emirates (+971)</option>
          <option value="UY"  data-code="598">Uruguay (+598)</option>
          <option value="US"  data-code="1">USA (+1)</option>
          <option value="UZ"  data-code="7">Uzbekistan (+7)</option>
          <option value="VU"  data-code="678">Vanuatu (+678)</option>
          <option value="VA"  data-code="379">Vatican City (+379)</option>
          <option value="VE"  data-code="58">Venezuela (+58)</option>
          <option value="VN"  data-code="84">Vietnam (+84)</option>
          <option value="VG"  data-code="84">Virgin Islands - British (+1284)</option>
          <option value="VI"  data-code="84">Virgin Islands - US (+1340)</option>
          <option value="WF"  data-code="681">Wallis &amp; Futuna (+681)</option>
          <option value="YE"  data-code="969">Yemen (North)(+969)</option>
          <option value="YE"  data-code="967">Yemen (South)(+967)</option>
          <option value="ZM"  data-code="260">Zambia (+260)</option>
          <option value="ZW"  data-code="263">Zimbabwe (+263)</option>';
        // return' <optgroup label="North America">
        //                                             <option>Alabama</option>
        //                                             <option>Alaska</option>
        //                                             <option>Arizona</option>
        //                                             <option>Arkansas</option>
        //                                             <option>California</option>
        //                                             <option>Colorado</option>
        //                                             <option>Connecticut</option>
        //                                             <option>Delaware</option>
        //                                             <option>Florida</option>
        //                                             <option>Georgia</option>
        //                                             <option>Hawaii</option>
        //                                             <option>Idaho</option>
        //                                             <option>Illinois</option>
        //                                             <option>Indiana</option>
        //                                             <option>Iowa</option>
        //                                             <option>Kansas</option>
        //                                             <option>Kentucky[C]</option>
        //                                             <option>Louisiana</option>
        //                                             <option>Maine</option>
        //                                             <option>Maryland</option>
        //                                             <option>Massachusetts[D]</option>
        //                                             <option>Michigan</option>
        //                                             <option>Minnesota</option>
        //                                             <option>Mississippi</option>
        //                                             <option>Missouri</option>
        //                                             <option>Montana</option>
        //                                             <option>Nebraska</option>
        //                                             <option>Nevada</option>
        //                                             <option>New Hampshire</option>
        //                                             <option>New Jersey</option>
        //                                             <option>New Mexico</option>
        //                                             <option>New York</option>
        //                                             <option>North Carolina</option>
        //                                             <option>North Dakota</option>
        //                                             <option>Ohio</option>
        //                                             <option>Oklahoma</option>
        //                                             <option>Oregon</option>
        //                                             <option>Pennsylvania[E]</option>
        //                                             <option>Rhode Island[F]</option>
        //                                             <option>South Carolina</option>
        //                                             <option>South Dakota</option>
        //                                             <option>Tennessee</option>
        //                                             <option>Texas</option>
        //                                             <option>Utah</option>
        //                                             <option>Vermont</option>
        //                                             <option>Virginia[G]</option>
        //                                             <option>Washington</option>
        //                                             <option>West Virginia</option>
        //                                             <option>Wisconsin</option>
        //                                             <option>Wyoming</option>
        //                                         </optgroup>
        //                                         <optgroup label="Europe">
        //                                             <option>Albania</option>
        //                                             <option>Andorra</option>
        //                                             <option>Armenia</option>
        //                                             <option>Austria</option>
        //                                             <option>Azerbaijan</option>
        //                                             <option>Belarus</option>
        //                                             <option>Belgium</option>
        //                                             <option>Bosnia & Herzegovina</option>
        //                                             <option>Bulgaria</option>
        //                                             <option>Croatia</option>
        //                                             <option>Cyprus</option>
        //                                             <option>Czech Republic</option>
        //                                             <option>Denmark</option>
        //                                             <option>Estonia</option>
        //                                             <option>Finland</option>
        //                                             <option>France</option>
        //                                             <option>Georgia</option>
        //                                             <option>Germany</option>
        //                                             <option>Greece</option>
        //                                             <option>Hungary</option>
        //                                             <option>Iceland</option>
        //                                             <option>Ireland</option>
        //                                             <option>Italy</option>
        //                                             <option>Kosovo</option>
        //                                             <option>Latvia</option>
        //                                             <option>Liechtenstein</option>
        //                                             <option>Lithuania</option>
        //                                             <option>Luxembourg</option>
        //                                             <option>Macedonia</option>
        //                                             <option>Malta</option>
        //                                             <option>Moldova</option>
        //                                             <option>Monaco</option>
        //                                             <option>Montenegro</option>
        //                                             <option>The Netherlands</option>
        //                                             <option>Norway</option>
        //                                             <option>Poland</option>
        //                                             <option>Portugal</option>
        //                                             <option>Romania</option>
        //                                             <option>Russia</option>
        //                                             <option>San Marino</option>
        //                                             <option>Serbia</option>
        //                                             <option>Slovakia</option>
        //                                             <option>Slovenia</option>
        //                                             <option>Spain</option>
        //                                             <option>Sweden</option>
        //                                             <option>Switzerland</option>
        //                                             <option>Turkey</option>
        //                                             <option>Ukraine</option>
        //                                             <option>United Kingdom</option>
        //                                             <option>Vatican City (Holy See)</option>
        //                                         </optgroup>
        //                                         <optgroup label="Asia">
        //                                             <option>Afghanistan</option>
        //                                             <option>Bahrain</option>
        //                                             <option>Bangladesh</option>
        //                                             <option>Bhutan</option>
        //                                             <option>Brunei</option>
        //                                             <option>Cambodia</option>
        //                                             <option>China</option>
        //                                             <option>East Timor</option>
        //                                             <option>India</option>
        //                                             <option value="Indonesia" data-code="+62">Indonesia</option>
        //                                             <option>Iran</option>
        //                                             <option>Iraq</option>
        //                                             <option>Israel</option>
        //                                             <option>Japan</option>
        //                                             <option>Jordan</option>
        //                                             <option>Kazakhstan</option>
        //                                             <option>Korea North</option>
        //                                             <option>Korea South</option>
        //                                             <option>Kuwait</option>
        //                                             <option>Kyrgyzstan</option>
        //                                             <option>Laos</option>
        //                                             <option>Lebanon</option>
        //                                             <option>Malaysia</option>
        //                                             <option>Maldives</option>
        //                                             <option>Mongolia</option>
        //                                             <option>Myanmar (Burma)</option>
        //                                             <option>Nepal</option>
        //                                             <option>Oman</option>
        //                                             <option>Pakistan</option>
        //                                             <option>The Philippines</option>
        //                                             <option>Qatar</option>
        //                                             <option>Russia</option>
        //                                             <option>Saudi Arabia</option>
        //                                             <option>Singapore</option>
        //                                             <option>Sri Lanka</option>
        //                                             <option>Syria</option>
        //                                             <option>Taiwan</option>
        //                                             <option>Tajikistan</option>
        //                                             <option>Thailand</option>
        //                                             <option>Turkey</option>
        //                                             <option>Turkmenistan</option>
        //                                             <option>United Arab Emirates</option>
        //                                             <option>Uzbekistan</option>
        //                                             <option>Vietnam</option>
        //                                             <option>Yemen</option>
        //                                         </optgroup>';
    }


}
if (!function_exists('list_approval')) {

    function list_approval($moduleKode='', $dataId='') {
        $ci =& get_instance();
        $rows = $ci->M_approval->list($moduleKode, $dataId);
        $data['rows'] = $rows;
        $userId = $ci->session->userdata('ID_USER');
        $cek = $ci->db->where('ID_USER',$userId)->get('m_user')->row();
        $roles = explode(",", $cek->ROLES);
        $data['roles'] = array_values(array_filter($roles));
        $data['data_id'] = $dataId;
        $data['module_kode'] = $moduleKode;
        $data['msr'] = $ci->db->where('msr_no',$dataId)->get('t_msr')->row();
        $ci->load->view('approval/list', $data);
    }

}
function langApproval($value='')
{
    $list[1] = ['title'=>'Approve'];
    $list[2] = ['title'=>'Reject'];
    $list[3] = ['title'=>'-'];
    $list[4] = ['title'=>'Assignment'];
    $list[5] = ['title'=>'BL&ED'];

    if($value)
        return $list[$value];
}
function user($param=0) {
    $ci =& get_instance();
    $session = $ci->session->userdata('ID_USER');
    if($param > 0)
        return $ci->db->where(['ID_USER'=>$param])->get('m_user')->row();

    return $ci->db->where(['ID_USER'=>$session])->get('m_user')->row();
}

function supplier($id = null) {
    $ci =& get_instance();
    $m_vendor = 'm_vendor';

    $user_id = $id ?: $ci->session->userdata('ID');

    return $ci->db->where([
        'ID' => $user_id
        ])->get($m_vendor)->row();
}

function generate_msr_approval($msr_no='')
{
    $ci =& get_instance();
    $ci->load->model('approval/M_approval');
    $ci->M_approval->generate_msr_approval($msr_no);
}
function msrType($idmsr='')
{
    $ci =& get_instance();
    return $ci->db->where('ID_MSR',$idmsr)->get('m_msrtype')->row();
}
function pMethod($pk='')
{
    $ci =& get_instance();
    return $ci->db->where('ID_PMETHOD',$pk)->get('m_pmethod')->row();
}
function optMethod($name='', $selected='', $attributes = '')
{
    $ci =& get_instance();
    $x =  $ci->db->get('m_pmethod')->result();
    $s = "<select name='$name' id='$name' class='form-control' ".$attributes.">";
    foreach ($x as $key => $value) {
        $select = $selected == $value->ID_PMETHOD ? "selected":"";
        $s .= "<option $select value='$value->ID_PMETHOD' ".$select.">$value->PMETHOD_DESC</option>";
    }
    $s .= "</select>";
    return $s;
}
function optCurrency($name='', $selected='', $attr='')
{
    $ci =& get_instance();
    $x =  $ci->db->get('m_currency')->result();
    $s = "<select name='$name' id='$name' class='form-control' $attr>";
    foreach ($x as $key => $value) {
        $select = $selected == $value->ID ? "selected":"";
        $s .= "<option value='$value->ID' $select>$value->CURRENCY</option>";
    }
    $s .= "</select>";
    return $s;
}
function biduploadtype($value='', $get=false)
{
    $a[] = 'Instruction To Bid'; /*req*/
    $a[] = 'Form Of Bid';
    $a[] = 'Form of PO/SO/Contract'; /*req*/
    for ($i='A'; $i <= 'J' ; $i++) {
        $a[] = 'Exhibit '.$i;/*req;A-j=10;start a = 3; 3-12*/
    }
    $a[] = 'Other';
    if($get)
        return $a[$value];

    return $a;
}
function optLocation($name='', $selected='',$class='')
{
    $ci =& get_instance();
    $x =  $ci->db->get('m_location')->result();
    $s = "<select name='$name' id='$name' class='form-control' $class>";
    foreach ($x as $key => $value) {
        $select = $selected == $value->ID_LOCATION ? "selected":"";
        $s .= "<option value='$value->ID_LOCATION'>$value->LOCATION_DESC</option>";
    }
    $s .= "</select>";
    return $s;
}
function get_hari_all(){
    return array(
        '1'=>'Senin',
        '2'=>'Selasa',
        '3'=>'Rabu',
        '4'=>'Kamis',
        '5'=>"Jum'at",
        '6'=>'Sabtu',
        '7'=>'Minggu'
        );
}

function get_bulan_all($getBulan=null){
    $bulan=array(
        '01'=>'Januari',
        '02'=>'Februari',
        '03'=>'Maret',
        '04'=>'April',
        '05'=>'Mei',
        '06'=>'Juni',
        '07'=>'Juli',
        '08'=>'Agustus',
        '09'=>'September',
        '10'=>'Oktober',
        '11'=>'November',
        '12'=>'Desember'
    );
  if($getBulan == null)
    return $bulan;
  else{
    $i = $getBulan;
    if($getBulan < 10) $i = "0".$getBulan;
    return $bulan[$i];
  }
}
function dateToIndo($date="",$day=false,$time=false){
    if ($date && $date <> '0000-00-00 00:00:00' && $date <> '0000-00-00') {
      $bulan=get_bulan_mini();
      $hari=get_hari_all();
      $d=date('d',  strtotime($date));
      $m=date('m',  strtotime($date));
      $y=date('Y',  strtotime($date));
      $n=date('N',  strtotime($date));
      $t=date('H:i', strtotime($date));
      if($day)
          $date = $hari[$n].", ".$d." ".$bulan[$m]." ".$y." ";
      else
          $date = $d." ".$bulan[$m]." ".$y.' ';

      if($time)
          $date .= $t;
    } else {
      $date = '';
    }
    return $date;
}
function dateToInput($date, $format = 'Y-m-d') {
  if ($date && $date <> '0000-00-00 00:00:00' && $date <> '0000-00-00') {
    return date($format, strtotime($date));
  } else {
    return '';
  }

}
function get_bulan_mini($getBulan=null){
    $bulan=array(
        '01'=>'Jan',
        '02'=>'Feb',
        '03'=>'Mar',
        '04'=>'Apr',
        '05'=>'Mei',
        '06'=>'Jun',
        '07'=>'Jul',
        '08'=>'Aug',
        '09'=>'Sep',
        '10'=>'Oct',
        '11'=>'Nov',
        '12'=>'Dec'
    );
  if($getBulan == null)
    return $bulan;
  else{
    $i = $getBulan;
    if($getBulan < 10) $i = "0".$getBulan;
    return $bulan[$i];
  }
}
function optStatusBid($name='', $selected='')
{
    $ci =& get_instance();
    $list = statusBid();
    $s = "<select name='$name' id='$name' class='form-control'>";
    foreach ($list as $key => $value) {
        $select = $selected == $value ? "selected":"";
        $s .= "<option value='$key'>$value</option>";
    }
    $s .= "</select>";
    return $s;
}
function statusBid($value='')
{
  $list[1] = 'Open';
  $list[2] = 'Close';
  if($value)
    return $list[$value];
  return $list;
}
function statusBidVendor($value='')
{
  $list[0] = 'Not Confirmed Yet';
  $list[1] = 'Bid Proposal Submitted';
  $list[2] = 'Withdrawal';
  return $list[$value];
}

function statusBidOpening($value='')
{
  $list[0] = 'Invitation';
  $list[1] = 'Opened';
  return $list[$value];
}
function numIndo($num,$precision=2,$decimal='.',$thousand=','){
  if (is_null($num)) {
    return null;
  }
  if($num===''){
   return null;
  }
  $num = (float) $num;
  return number_format($num,$precision,$decimal,$thousand);
}

function numEng($num,$precision=2){
  return numIndo($num, $precision, '.', ',');
}
function evaluationStatus($value='')
{
  $list[0] = 'Not Evaluation Yet';
  $list[1] = 'Pass';
  $list[2] = 'Fail';
  return $list[$value];
}

function admTechCom($value='')
{
  $list[0] = 'Pass/Fail';
  $list[1] = 'Merit Point';

  if($value < 2)
    return $list[$value];

  return $list;
}
function optAdmTechCOm($name='', $selected='')
{
    $list = admTechCom(3);
    $s = "<select name='$name' id='$name' class='form-control'>";
    foreach ($list as $key => $value) {
        $select = $selected == $value ? "selected":"";
        $s .= "<option value='$key'>$value</option>";
    }
    $s .= "</select>";
    return $s;
}


if (!function_exists('get_main_menu'))
{
    function get_main_menu() {
        $ci =& get_instance();
        $ci->load->model('vendor/M_vendor');

        $get_menu = $ci->M_vendor->menu();
        $menu = array();
        foreach ($get_menu as $k => $v) {
            $menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }

        return $menu;
    }
}

if (!function_exists('get_main_vendor_menu'))
{
    function get_main_vendor_menu() {
        $ci =& get_instance();
        $ci->load->model('vn/info/M_vn', 'mvn');

        $get_menu = $ci->mvn->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }

        return $dt;
    }
}
function msrPajak($value='', $total=false)
{
  $pajak = (($value*10)/100);
  if($total)
    return $pajak;

  return $value+$pajak;
}
function edOptData($type='adm', $value='')
{
  if($type == 'adm'){
    $list[1] = 'Pass/Fail';
  }
  if($type == 'tech'){
    $list[1] = 'Pass/Fail';
    $list[2] = 'Scoring';
  }
  if($type == 'com'){
    $list[1] = 'Lowest';
    $list[2] = 'Merit Point';
  }
  if($type == 'mix')
  {
    $list[1] = 'Pass/Fail';
    $list[2] = 'Merit Point';
  }

  if($value)
    return $list[$value];

  return $list;
}
function optEd($opt='adm', $name='', $selected='')
{
  $list = edOptData($opt);

  $s = "<select name='$name' id='$name' class='form-control'>";
  foreach ($list as $key => $value) {
      $select = $selected == $key ? "selected":"";
      $s .= "<option $select value='$key'>$value</option>";
  }
  $s .= "</select>";
  return $s;
}
function optPreBidLocation($name='', $selected='',$class='')
{
    $ci =& get_instance();
    $x =  $ci->db->where('active', 1)->get('m_pre_bid_location')->result();
    $s = "<select name='$name' id='$name' class='form-control' $class>";
    $s .= "<option value='0'>Not Aplicable</option>";
    foreach ($x as $key => $value) {
        $select = $selected == $value->id ? "selected":"";
        $s .= "<option value='$value->id' alamat='$value->alamat' ".$select.">$value->nama</option>";
    }
    $s .= "</select>";
    return $s;
}
function pcApprove($in=true)
{
  /*
  *list pc 1 chairman 4 member
  *
    klo dari flow yg ini, yang bisa jabat double adalah procurement head . Jadi menjabat sebagai procurement head juga menjabat procurement committee sebagai chairman (ketua).
    Note : Procurement committee itu terdiri dari 1 chairman dan 4 member. dgn rincian sbb :
    1. Chairman (ketua) 165
    2. Member (legal councel) 182
    3. Member (VP BSD) 179
    4. Member (VP Finance) 151
    5. Member (VP Relation, SHE, & Security). 140
    konsep approval member di procurement committee tidak serial antar member, tetapi parallel antar member,
  */
  /*chariman*/
  $ci =& get_instance();
  $chairman = $ci->db->like('roles','100004')->get('m_user');
  $chairman = $chairman->row();
  $chairman = $chairman->ID_USER;
  /*legal_councel*/
  $legal_councel = $ci->db->like('roles','100006')->get('m_user');
  $legal_councel = $legal_councel->row();
  $legal_councel = $legal_councel->ID_USER;
  /*vp_bsd*/
  $vp_bsd = $ci->db->like('roles','21')->get('m_user');
  $vp_bsd = $vp_bsd->row();
  $vp_bsd = $vp_bsd->ID_USER;
  /*vp_finance*/
  $vp_finance = $ci->db->like('roles','31')->get('m_user');
  $vp_finance = $vp_finance->row();
  $vp_finance = $vp_finance->ID_USER;
  /*vp_relation SHE*/
  $vp_relation = $ci->db->like('roles','39')->get('m_user');
  $vp_relation = $vp_relation->row();
  $vp_relation = $vp_relation->ID_USER;

  $list = [$chairman,$legal_councel,$vp_bsd,$vp_finance,$vp_relation];
  if($in)
    return $list = [$chairman,$legal_councel];

  return $list;
}

if (!function_exists('get_vat_value'))
{
    function get_vat_value() {
        return 0.1; // 10 %
    }
}

if (!function_exists('calculate_vat_amount'))
{
    function calculate_vat_amount($amount, $include_vat = true) {
        $vat_value = $include_vat ? get_vat_value() : 0;
        return $amount * $vat_value;
    }
}

if (!function_exists('calculate_amount_with_vat'))
{
    function calculate_amount_with_vat($amount, $include_vat = true) {
        return $amount + calculate_vat_amount($amount, $include_vat);
    }
}

if (!function_exists('log_history'))
{
    function log_history($module_kode, $data_id, $description, $keterangan = '') {
        $ci =& get_instance();
        $ci->load->model('approval/M_log');
        $created_at = today_sql();
        $created_by = $ci->session->userdata('ID_USER') ?: $ci->session->userdata('ID');

        $ci->M_log->store(compact('module_kode', 'data_id', 'description', 'keterangan',
            'created_at', 'created_by'));
    }
}
function can_perform_n_submit_admin_evaluation($ed)
{
  $ci =& get_instance();
  $ci->session->userdata('ID_USER');

  $permitted_role = bled; /*proc specialist*/

  $user = user();
  $roles = explode(",", $user->ROLES);
  $roles = array_values(array_filter($roles));

  if (in_array($permitted_role, $roles) and $ed->administrative == 0) {

    $ci->load->model('approval/M_bl');
    $ci->db->where(['administrative'=>0]);
    $t_bl_detail = $ci->db->where(['msr_no'=>$ed->msr_no])->get('t_bl_detail');

    if($t_bl_detail->num_rows() > 0)
      return false;
    else
      return true;
  }
  return false;
}
function can_approval_admin_evaluation($msr_no)
{
  $ci =& get_instance();

  $permitted_role = bled; /*proc specialist*/

  $teqdata = $ci->M_approval->teqdata(['administrative'=>1, 'msr_no'=>$msr_no]);

  $user = user();
  $roles = explode(",", $user->ROLES);
  $roles = array_values(array_filter($roles));

  if (in_array($permitted_role, $roles) and $teqdata->num_rows() == 1) {
    return true;
  }
  return false;
}
/*function can($ed, $param='')
{
  $ci =& get_instance();
  $ci->session->userdata('ID_USER');

  $permitted_role = bled;

  $user = user();
  $roles = explode(",", $user->ROLES);
  $roles = array_values(array_filter($roles));

  if (in_array($permitted_role, $roles) and $ed->$param == 0) {

    $ci->load->model('approval/M_bl');
    $ci->db->where([$param=>0]);
    $t_bl_detail = $ci->db->where(['msr_no'=>$ed->msr_no])->get('t_bl_detail');

    if($t_bl_detail->num_rows() > 0)
      return false;
    else
      return true;
  }
  return false;
}*/
function time_approval_ed($msr_no)
{
  $ci =& get_instance();
  $ci->load->model('M_bl');
  return $ci->M_bl->time_approval_ed($msr_no);
}
function optIncoterm($name='incoterm', $selected='',$class='')
{
    $ci =& get_instance();
    $x =  $ci->db->get('m_deliveryterm')->result();
    $s = "<select name='$name' id='$name' class='form-control' $class>";
    $s.= '<option value="">Please Select</option>';
    foreach ($x as $key => $value) {
        $select = $selected == $value->ID_DELIVERYTERM ? "selected":"";
        $s .= "<option value='$value->ID_DELIVERYTERM' ".$select.">$value->DELIVERYTERM_DESC</option>";
    }
    $s .= "</select>";
    return $s;
}
function optDpoint($name='delivery_point', $selected='',$class='')
{
    $ci =& get_instance();
    $x =  $ci->db->where('status', '1')->get('m_deliverypoint')->result();
    $s = "<select name='$name' id='$name' class='form-control' $class>";
    $s.= '<option value="">Please Select</option>';
    foreach ($x as $key => $value) {
        $select = $selected == $value->ID_DPOINT ? "selected":"";
        $s .= "<option value='$value->ID_DPOINT' ".$select.">$value->DPOINT_DESC</option>";
    }

    $s .= "</select>";
    return $s;
}
function bod($key='',$perusahaan_id='')
{
  /*bod
  * 45 COO victor van der mast
  * 46 CEO Supramu, Radikal Utama
  * 47 CFO Akio Kajimoto
  * 47 CFO Rantau Dedap Hisahiro takeuchi
  * [45=>35,46=>32,47=>34]
  * [45=>35,46=>32,47=>38]
  */
  $list[45] = [35];
  $list[46] = [32];
  $list[47] = [34];
  if($perusahaan_id==10103)
    $list[47] = [38];
  return $list[$key];
}


function number_value($str) {
    if (!is_numeric($str)) {
        $parse = explode('.', $str);
        $result = str_replace(',', "", $parse[0]);
        if (is_numeric($result)) {
            if (isset($parse[1])) {
                $result .= '.' . $parse[1];
            }
            return $result;
        } else {
            return 0;
        }
    } else {
        return $str;
    }
}
function arfRecomPrepType($value='', $get=false)
{
    $a[] = 'Draft Amendment'; /*req*/
    $a[] = 'Other';
    if($get)
        return $a[$value];

    return $a;
}
function equal_to($msr='')
{
  if($msr->currency != 'USD')
  {
    return "<br><small>(equal to USD ".numIndo($msr->total_amount_base).')</small>';
  }
}

function __($line, $parser = array()) {
  $CI = &get_instance();
  $lang = $CI->lang->line($line);
  foreach ($parser as $i => $j) {
    $lang = str_replace(':'.$i, $j, $lang);
  }
  return $lang;
}
function arfIssuedDoc($value=0)
{
  $list[1] = 'Amendment Signed';
  $list[2] = 'Counter Signed';
  if($value > 0)
  {
    return @$list[$value];
  }
  return $list;
}