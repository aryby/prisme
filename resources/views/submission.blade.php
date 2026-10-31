@extends('layouts.app')

@section('title', 'Paper Submission -SIPRISME 2026')
@section('description', 'Submission guidelines for SIPRISME 2026. Learn about abstract and full paper requirements, review process, and submission details.')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="titleborder">
                <div>Paper Submission</div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span12">
            <div class="well">
                <h3>Submission Modalities</h3>
                <p>
                    Submission takes place in two stages: an abstract first, followed by the full paper after acceptance.
                </p>

                <h4>Extended abstract</h4>
                <ul>
                    <li>500 to 800 words, in French, English, or Arabic</li>
                    <li>Title, author name(s), affiliations, and email address</li>
                    <li>Selected thematic axis</li>
                    <li>Research problem, theoretical framework, methodology, and expected main results</li>
                    <li>3 to 5 keywords</li>
                </ul>

                <h4>Full paper</h4>
                <ul>
                    <li>15 to 20 pages, including references and appendices</li>
                    <li>Times New Roman 12 font, 1.5 line spacing</li>
                    <li>Bibliographic references in APA style (7th edition)</li>
                </ul>

                <p>
                    Proposals are evaluated through a double-blind peer review process by the Scientific Committee. Upload your paper as a PDF using the form below.
                </p>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span12">
            <div class="titleborder">
                <div>Submit Your Paper</div>
            </div>
        </div>
    </div>

    <div class="row-fluid">
        <div class="span12">
            <form class="form-horizontal" action="{{ route('submission.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="well">
                    <h3>Paper Information</h3>
                    <div class="control-group">
                        <label class="control-label" for="submission_option">Submission Option *</label>
                        <div class="controls">
                            <select id="submission_option" name="submission_option" class="input-xlarge" required>
                                <option value="">Select an Option</option>
                                <option value="full_submission">Full Submission</option>
                                <option value="abstract_submission">Abstract Submission</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="title">Paper Title *</label>
                        <div class="controls">
                            <input type="text" id="title" name="title" class="input-xlarge" required
                                placeholder="Enter your paper title">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="track">Symposium Track *</label>
                        <div class="controls">
                            <select id="track" name="track" class="input-xlarge" required>
                                <option value="">Select a track</option>
                                <option value="Transitions and Organizational Resilience">Transitions and Organizational Resilience</option>
                                <option value="Managing Transitions: Performance and Management Control">Managing Transitions: Performance and Management Control</option>
                                <option value="Digital Transformation and Artificial Intelligence">Digital Transformation and Artificial Intelligence</option>
                                <option value="Human Capital and Social Change">Human Capital and Social Change</option>
                                <option value="Territorial Resilience and Local Development">Territorial Resilience and Local Development</option>
                                <option value="New Value and Business Models">New Value and Business Models</option>
                                <option value="Governance, CSR, and Ethics">Governance, CSR, and Ethics</option>
                                <option value="Morocco and Africa Facing Transitions">Morocco and Africa Facing Transitions</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="abstract">Abstract *</label>
                        <div class="controls">
                            <textarea id="abstract" name="abstract" rows="4" class="input-xlarge" required
                                placeholder="Enter your abstract (150-250 words)"></textarea>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="keywords">Keywords *</label>
                        <div class="controls">
                            <input type="text" id="keywords" name="keywords" class="input-xlarge" required
                                placeholder="Enter 3-5 keywords separated by commas">
                        </div>
                    </div>
                </div>

                <div class="well">
                    <h3>Author Information</h3>

                    <div class="control-group">
                        <label class="control-label" for="name">Full Name *</label>
                        <div class="controls">
                            <input type="text" id="name" name="name" class="input-xlarge" required
                                placeholder="Enter your full name">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="email">Email Address *</label>
                        <div class="controls">
                            <input type="email" id="email" name="email" class="input-xlarge" required
                                placeholder="Enter email address">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="affiliation">Affiliation *</label>
                        <div class="controls">
                            <input type="text" id="affiliation" name="affiliation" class="input-xlarge" required
                                placeholder="Enter your institution/organization">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="country">Country *</label>
                        <div class="controls">
                            <select id="country" name="country" class="input-xlarge" required>
                                <option value="">Select your country</option>
                                <option value="AF">Afghanistan</option>
                                <option value="AX">Åland Islands</option>
                                <option value="AL">Albania</option>
                                <option value="DZ">Algeria</option>
                                <option value="AS">American Samoa</option>
                                <option value="AD">Andorra</option>
                                <option value="AO">Angola</option>
                                <option value="AI">Anguilla</option>
                                <option value="AG">Antigua and Barbuda</option>
                                <option value="AR">Argentina</option>
                                <option value="AM">Armenia</option>
                                <option value="AW">Aruba</option>
                                <option value="AU">Australia</option>
                                <option value="AT">Austria</option>
                                <option value="AZ">Azerbaijan</option>
                                <option value="BS">Bahamas</option>
                                <option value="BH">Bahrain</option>
                                <option value="BD">Bangladesh</option>
                                <option value="BB">Barbados</option>
                                <option value="BY">Belarus</option>
                                <option value="BE">Belgium</option>
                                <option value="BZ">Belize</option>
                                <option value="BJ">Benin</option>
                                <option value="BM">Bermuda</option>
                                <option value="BT">Bhutan</option>
                                <option value="BO">Bolivia</option>
                                <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
                                <option value="BA">Bosnia and Herzegovina</option>
                                <option value="BW">Botswana</option>
                                <option value="BR">Brazil</option>
                                <option value="IO">British Indian Ocean Territory</option>
                                <option value="VG">British Virgin Islands</option>
                                <option value="BN">Brunei</option>
                                <option value="BG">Bulgaria</option>
                                <option value="BF">Burkina Faso</option>
                                <option value="BI">Burundi</option>
                                <option value="CV">Cabo Verde</option>
                                <option value="KH">Cambodia</option>
                                <option value="CM">Cameroon</option>
                                <option value="CA">Canada</option>
                                <option value="KY">Cayman Islands</option>
                                <option value="CF">Central African Republic</option>
                                <option value="TD">Chad</option>
                                <option value="CL">Chile</option>
                                <option value="CN">China</option>
                                <option value="CX">Christmas Island</option>
                                <option value="CC">Cocos (Keeling) Islands</option>
                                <option value="CO">Colombia</option>
                                <option value="KM">Comoros</option>
                                <option value="CD">Congo, Democratic Republic of the</option>
                                <option value="CG">Congo, Republic of the</option>
                                <option value="CK">Cook Islands</option>
                                <option value="CR">Costa Rica</option>
                                <option value="CI">Côte d’Ivoire</option>
                                <option value="HR">Croatia</option>
                                <option value="CU">Cuba</option>
                                <option value="CW">Curaçao</option>
                                <option value="CY">Cyprus</option>
                                <option value="CZ">Czechia</option>
                                <option value="DK">Denmark</option>
                                <option value="DJ">Djibouti</option>
                                <option value="DM">Dominica</option>
                                <option value="DO">Dominican Republic</option>
                                <option value="EC">Ecuador</option>
                                <option value="EG">Egypt</option>
                                <option value="SV">El Salvador</option>
                                <option value="GQ">Equatorial Guinea</option>
                                <option value="ER">Eritrea</option>
                                <option value="EE">Estonia</option>
                                <option value="SZ">Eswatini</option>
                                <option value="ET">Ethiopia</option>
                                <option value="FK">Falkland Islands</option>
                                <option value="FO">Faroe Islands</option>
                                <option value="FJ">Fiji</option>
                                <option value="FI">Finland</option>
                                <option value="FR">France</option>
                                <option value="GF">French Guiana</option>
                                <option value="PF">French Polynesia</option>
                                <option value="GA">Gabon</option>
                                <option value="GM">Gambia</option>
                                <option value="GE">Georgia</option>
                                <option value="DE">Germany</option>
                                <option value="GH">Ghana</option>
                                <option value="GI">Gibraltar</option>
                                <option value="GR">Greece</option>
                                <option value="GL">Greenland</option>
                                <option value="GD">Grenada</option>
                                <option value="GP">Guadeloupe</option>
                                <option value="GU">Guam</option>
                                <option value="GT">Guatemala</option>
                                <option value="GG">Guernsey</option>
                                <option value="GN">Guinea</option>
                                <option value="GW">Guinea-Bissau</option>
                                <option value="GY">Guyana</option>
                                <option value="HT">Haiti</option>
                                <option value="HN">Honduras</option>
                                <option value="HK">Hong Kong</option>
                                <option value="HU">Hungary</option>
                                <option value="IS">Iceland</option>
                                <option value="IN">India</option>
                                <option value="ID">Indonesia</option>
                                <option value="IR">Iran</option>
                                <option value="IQ">Iraq</option>
                                <option value="IE">Ireland</option>
                                <option value="IM">Isle of Man</option>
                                <option value="IT">Italy</option>
                                <option value="JM">Jamaica</option>
                                <option value="JP">Japan</option>
                                <option value="JE">Jersey</option>
                                <option value="JO">Jordan</option>
                                <option value="KZ">Kazakhstan</option>
                                <option value="KE">Kenya</option>
                                <option value="KI">Kiribati</option>
                                <option value="XK">Kosovo</option>
                                <option value="KW">Kuwait</option>
                                <option value="KG">Kyrgyzstan</option>
                                <option value="LA">Laos</option>
                                <option value="LV">Latvia</option>
                                <option value="LB">Lebanon</option>
                                <option value="LS">Lesotho</option>
                                <option value="LR">Liberia</option>
                                <option value="LY">Libya</option>
                                <option value="LI">Liechtenstein</option>
                                <option value="LT">Lithuania</option>
                                <option value="LU">Luxembourg</option>
                                <option value="MO">Macao</option>
                                <option value="MG">Madagascar</option>
                                <option value="MW">Malawi</option>
                                <option value="MY">Malaysia</option>
                                <option value="MV">Maldives</option>
                                <option value="ML">Mali</option>
                                <option value="MT">Malta</option>
                                <option value="MH">Marshall Islands</option>
                                <option value="MQ">Martinique</option>
                                <option value="MR">Mauritania</option>
                                <option value="MU">Mauritius</option>
                                <option value="YT">Mayotte</option>
                                <option value="MX">Mexico</option>
                                <option value="FM">Micronesia</option>
                                <option value="MD">Moldova</option>
                                <option value="MC">Monaco</option>
                                <option value="MN">Mongolia</option>
                                <option value="ME">Montenegro</option>
                                <option value="MS">Montserrat</option>
                                <option value="MA">Morocco</option>
                                <option value="MZ">Mozambique</option>
                                <option value="MM">Myanmar</option>
                                <option value="NA">Namibia</option>
                                <option value="NR">Nauru</option>
                                <option value="NP">Nepal</option>
                                <option value="NL">Netherlands</option>
                                <option value="NC">New Caledonia</option>
                                <option value="NZ">New Zealand</option>
                                <option value="NI">Nicaragua</option>
                                <option value="NE">Niger</option>
                                <option value="NG">Nigeria</option>
                                <option value="NU">Niue</option>
                                <option value="NF">Norfolk Island</option>
                                <option value="KP">North Korea</option>
                                <option value="MK">North Macedonia</option>
                                <option value="MP">Northern Mariana Islands</option>
                                <option value="NO">Norway</option>
                                <option value="OM">Oman</option>
                                <option value="PK">Pakistan</option>
                                <option value="PW">Palau</option>
                                <option value="PS">Palestine</option>
                                <option value="PA">Panama</option>
                                <option value="PG">Papua New Guinea</option>
                                <option value="PY">Paraguay</option>
                                <option value="PE">Peru</option>
                                <option value="PH">Philippines</option>
                                <option value="PN">Pitcairn Islands</option>
                                <option value="PL">Poland</option>
                                <option value="PT">Portugal</option>
                                <option value="PR">Puerto Rico</option>
                                <option value="QA">Qatar</option>
                                <option value="RE">Réunion</option>
                                <option value="RO">Romania</option>
                                <option value="RU">Russia</option>
                                <option value="RW">Rwanda</option>
                                <option value="WS">Samoa</option>
                                <option value="SM">San Marino</option>
                                <option value="ST">São Tomé and Príncipe</option>
                                <option value="SA">Saudi Arabia</option>
                                <option value="SN">Senegal</option>
                                <option value="RS">Serbia</option>
                                <option value="SC">Seychelles</option>
                                <option value="SL">Sierra Leone</option>
                                <option value="SG">Singapore</option>
                                <option value="SX">Sint Maarten</option>
                                <option value="SK">Slovakia</option>
                                <option value="SI">Slovenia</option>
                                <option value="SB">Solomon Islands</option>
                                <option value="SO">Somalia</option>
                                <option value="ZA">South Africa</option>
                                <option value="KR">South Korea</option>
                                <option value="SS">South Sudan</option>
                                <option value="ES">Spain</option>
                                <option value="LK">Sri Lanka</option>
                                <option value="BL">St. Barthélemy</option>
                                <option value="SH">St. Helena</option>
                                <option value="KN">St. Kitts and Nevis</option>
                                <option value="LC">St. Lucia</option>
                                <option value="MF">St. Martin</option>
                                <option value="PM">St. Pierre and Miquelon</option>
                                <option value="VC">St. Vincent and the Grenadines</option>
                                <option value="SD">Sudan</option>
                                <option value="SR">Suriname</option>
                                <option value="SJ">Svalbard and Jan Mayen</option>
                                <option value="SE">Sweden</option>
                                <option value="CH">Switzerland</option>
                                <option value="SY">Syria</option>
                                <option value="TW">Taiwan</option>5
                                <option value="TJ">Tajikistan</option>
                                <option value="TZ">Tanzania</option>
                                <option value="TH">Thailand</option>
                                <option value="TL">Timor-Leste</option>
                                <option value="TG">Togo</option>
                                <option value="TK">Tokelau</option>
                                <option value="TO">Tonga</option>
                                <option value="TT">Trinidad and Tobago</option>
                                <option value="TN">Tunisia</option>
                                <option value="TR">Türkiye</option>
                                <option value="TM">Turkmenistan</option>
                                <option value="TC">Turks and Caicos Islands</option>
                                <option value="TV">Tuvalu</option>
                                <option value="UG">Uganda</option>
                                <option value="UA">Ukraine</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="UK">United Kingdom</option>
                                <option value="US">United States</option>
                                <option value="UM">United States Minor Outlying Islands</option>
                                <option value="VI">United States Virgin Islands</option>
                                <option value="UY">Uruguay</option>
                                <option value="UZ">Uzbekistan</option>
                                <option value="VU">Vanuatu</option>
                                <option value="VA">Vatican City</option>
                                <option value="VE">Venezuela</option>
                                <option value="VN">Vietnam</option>
                                <option value="WF">Wallis and Futuna</option>
                                <option value="YE">Yemen</option>
                                <option value="ZM">Zambia</option>
                                <option value="ZW">Zimbabwe</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="phone">Phone Number</label>
                        <div class="controls">
                            <input type="tel" id="phone" name="phone" class="input-xlarge"
                                placeholder="Enter phone number">
                        </div>
                    </div>
                </div>

                <div class="well">
                    <h3>Paper Upload</h3>
                    <div class="control-group">
                        <label class="control-label" for="file">Upload Paper *</label>
                        <div class="controls">
                            <input type="file" id="file" name="file" accept=".pdf" required>
                            <p class="help-block">PDF format only, maximum file size: 10 MB.</p>
                        </div>
                    </div>
                </div>

                <div class="well">
                    <h3>Terms and Conditions</h3>

                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="originality" required>
                                I confirm that this paper is original and has not been published elsewhere, nor is it currently under review by another Symposium or journal. *
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="copyright" required>
                                I agree to transfer copyright to SIPRISME 2026 if the paper is accepted for publication. *
                            </label>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="attendance" required>
                                I understand that at least one author must register and attend the Symposium to present the paper if accepted. *
                            </label>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-primary btn-large">Submit Paper</button>
                        <button type="reset" class="btn btn-default btn-large">Reset Form</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
