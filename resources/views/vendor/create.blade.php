@extends('../layouts.sbadmin2')

@section('content')
<link href="{{ asset('/themes/sb-admin2/css/career.css') }}" rel="stylesheet" type="text/css">
<!-- <div class="container-fluid">
    <a href="{{ '/vendor' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Add Vendor</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Please check your input code<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('vendor.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Firm Name</label>
                        <input type="text" class="form-control" placeholder="Firm name...." name="firm_name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Vendor Name</label>
                        <input type="text" class="form-control" placeholder="Name" name="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Mobile No.</label>
                        <input type="number" class="form-control" placeholder="Mobile Number" name="mobile">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Altername Number</label>
                        <input type="number" class="form-control" placeholder="alternate number" name="alt_number">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>GST State Code</label>
                        <select class="form-control" name="gst_state_code">
                        	<option disabled="" selected="">Select GST State Code</option>
                        	@foreach($gst as $gst_state)
                        		<?php $gst_id = str_pad($gst_state->id, 2, '0', STR_PAD_LEFT); ?>
                        		<option value="{{ $gst_id }}">{{ $gst_id }} | {{ $gst_state->state_name }}</option>
                        	@endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>GST No.</label>
                        <input type="text" class="form-control" placeholder="GST Number" name="gst_number">
                    </div>
                    <div class="col-md-12 checkbox" style="font-size: 12px; font-weight: bold; ">
                        <span style="color:#a94444; margin-right: 5px">If not GST no. </span>
                        <label><input type="checkbox" name="na_gst" value="1"><span style="color: #000; margin-left: 2px">N/A</span></label>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Items Dealing : </label>
                        <select name="item_id[]" class="form-control" multiple>
                        	<option disabled="">Select Items</option>
                        	@foreach($items as $item)
                        		<option value="{{ $item->id }}">{{ $item->title }}</option>
                        	@endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="5" placeholder="Address"></textarea>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary error-w3l-btn mt-sm-5 mt-3 px-4">Submit</button>
            </form>
        </div>
    </div>
</div> -->


<div class="container-fluid">
    <a href="{{ '/vendor' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Add Vendor</h5>

    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Products & Services</button>
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#BankDetails">Bank Details</button>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Please check your input code<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('vendor.store') }}" method="post" id="myForm">
            @csrf
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="input-field col s6 mb-3">
                            <select class="validate ipdis" id="vendor_type" name="vendor_type">
                              <option value="" class=""></option>
                              <option label="Supplier">Supplier</option>
                              <option label="Sub-Contractor">Sub-Contractor</option>
                              <option label="PRW">PRW</option>
                              <option label="Recruiting Agency">Recruiting Agency</option>
                              <option label="Mobile Service">Mobile Service</option>
                              <option label="Others">Others</option>
                              <option label="Both Supplier-SubCon">Both Supplier-SubCon</option>
                              <option label="RNM Vendor">RNM Vendor</option>
                              <option label="Charity Beneficiary">Charity Beneficiary</option>
                              <option label="Property Administrator">Property Administrator</option>
                              <option label="Property Owner">Property Owner</option>
                              <option label="Consultant">Consultant</option>
                              <option label="Transporter">Transporter</option>
                              <option label="Related Party">Related Party</option>
                            </select>
                            <label for="vendor_type" style="color: black !important" class="active">Vendor Type *</label>
                        </div>

                        <div class="input-field col s6 mb-3">
                            <select class="validate valid" id="firm_type" name="firm_type">
                              <option value="" class=""></option>
                              <option label="Co-Op. Society" value="object:51">Co-Op. Society</option>
                              <option label="Govt. Departmental Undertaking" value="object:52">Govt. Departmental Undertaking</option>
                              <option label="Ltd. Company" value="object:53">Ltd. Company</option>
                              <option label="NA" value="object:54">NA</option>
                              <option label="Partnership LLP" value="object:55">Partnership LLP</option>
                              <option label="Public Corporation" value="object:56">Public Corporation</option>
                              <option label="PVT. LTD" value="object:57">PVT. LTD</option>
                              <option label="Pvt. Ltd." value="object:58">Pvt. Ltd.</option>
                              <option label="Related Party" value="object:59">Related Party</option>
                              <option label="Sole Proprietorship" value="object:60">Sole Proprietorship</option>
                            </select>
                            <label for="firm_type" class="active">Firm Type *</label>
                        </div>

                        <div class="input-field col">
                            <input type="text" id="firm_name" name="firm_name">
                            <label for="firm_name" class="active">Firm Name *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="email" name="email">
                            <label for="email" class="active">Email *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="mobile" name="mobile">
                            <label for="mobile" class="active">Mobile No. *</label>
                        </div>

                        <!-- <div class="input-field col s4">
                            <input type="text" id="alt_number" name="alt_number">
                            <label for="alt_number" class="active">Alternate Mobile No.</label>
                        </div> -->

                        <div class="input-field col">
                            <input type="text" id="address" name="address">
                            <label for="address" class="active">Address *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="city" name="city">
                            <label for="city" class="active">City *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="postal_code" name="postal_code">
                            <label for="postal_code" class="active">Postal Code *</label>
                        </div>

                        <div class="input-field col s6 mb-3">
                            <select id="country" name="country">
                              <option value="" class=""></option>
                              <option label="Afghanistan" value="object:61">Afghanistan</option>
                              <option label="Albania" value="object:62">Albania</option>
                              <option label="Algeria" value="object:63">Algeria</option>
                              <option label="American Samoa" value="object:64">American Samoa</option>
                              <option label="Andorra" value="object:65">Andorra</option>
                              <option label="Angola" value="object:66">Angola</option>
                              <option label="Anguilla" value="object:67">Anguilla</option>
                              <option label="Antarctica" value="object:68">Antarctica</option>
                              <option label="Antigua and Barbuda" value="object:69">Antigua and Barbuda</option>
                              <option label="Argentina" value="object:70">Argentina</option>
                              <option label="Armenia" value="object:71">Armenia</option>
                              <option label="Aruba" value="object:72">Aruba</option>
                              <option label="Australia" value="object:73">Australia</option>
                              <option label="Austria" value="object:74">Austria</option>
                              <option label="Azerbaijan" value="object:75">Azerbaijan</option>
                              <option label="Bahamas" value="object:76">Bahamas</option>
                              <option label="Bahrain" value="object:77">Bahrain</option>
                              <option label="Bangladesh" value="object:78">Bangladesh</option>
                              <option label="Barbados" value="object:79">Barbados</option>
                              <option label="Belarus" value="object:80">Belarus</option>
                              <option label="Belgium" value="object:81">Belgium</option>
                              <option label="Belize" value="object:82">Belize</option>
                              <option label="Benin" value="object:83">Benin</option>
                              <option label="Bermuda" value="object:84">Bermuda</option>
                              <option label="Bhutan" value="object:85">Bhutan</option>
                              <option label="Bolivia" value="object:86">Bolivia</option>
                              <option label="Bosnia and Herzegovina" value="object:87">Bosnia and Herzegovina</option>
                              <option label="Botswana" value="object:88">Botswana</option>
                              <option label="Bouvet Island" value="object:89">Bouvet Island</option>
                              <option label="Brazil" value="object:90">Brazil</option>
                              <option label="British Indian Ocean Territory" value="object:91">British Indian Ocean Territory</option>
                              <option label="British Virgin Islands" value="object:92">British Virgin Islands</option>
                              <option label="Brunei Darussalam" value="object:93">Brunei Darussalam</option>
                              <option label="Bulgaria" value="object:94">Bulgaria</option>
                              <option label="Burkina Faso" value="object:95">Burkina Faso</option>
                              <option label="Burundi" value="object:96">Burundi</option>
                              <option label="Cambodia" value="object:97">Cambodia</option>
                              <option label="Cameroon" value="object:98">Cameroon</option>
                              <option label="Canada" value="object:99">Canada</option>
                              <option label="Cape Verde" value="object:100">Cape Verde</option>
                              <option label="Cayman Islands" value="object:101">Cayman Islands</option>
                              <option label="Central African Republic" value="object:102">Central African Republic</option>
                              <option label="Chad" value="object:103">Chad</option>
                              <option label="Chile" value="object:104">Chile</option>
                              <option label="China" value="object:105">China</option>
                              <option label="Christmas Island" value="object:106">Christmas Island</option>
                              <option label="Cocos" value="object:107">Cocos</option>
                              <option label="Colombia" value="object:108">Colombia</option>
                              <option label="Comoros" value="object:109">Comoros</option>
                              <option label="Congo - Brazzaville" value="object:110">Congo - Brazzaville</option>
                              <option label="Congo-Kinshasa" value="object:111">Congo-Kinshasa</option>
                              <option label="Cook Islands" value="object:112">Cook Islands</option>
                              <option label="Costa Rica" value="object:113">Costa Rica</option>
                              <option label="Croatia" value="object:114">Croatia</option>
                              <option label="Cuba" value="object:115">Cuba</option>
                              <option label="Cyprus" value="object:116">Cyprus</option>
                              <option label="Czech Republic" value="object:117">Czech Republic</option>
                              <option label="Denmark" value="object:118">Denmark</option>
                              <option label="Djibouti" value="object:119">Djibouti</option>
                              <option label="Dominica" value="object:120">Dominica</option>
                              <option label="Dominican Republic" value="object:121">Dominican Republic</option>
                              <option label="East Timor" value="object:122">East Timor</option>
                              <option label="Ecuador" value="object:123">Ecuador</option>
                              <option label="Egypt" value="object:124">Egypt</option>
                              <option label="El Salvador" value="object:125">El Salvador</option>
                              <option label="Equatorial Guinea" value="object:126">Equatorial Guinea</option>
                              <option label="Eritrea" value="object:127">Eritrea</option>
                              <option label="Estonia" value="object:128">Estonia</option>
                              <option label="Ethiopia" value="object:129">Ethiopia</option>
                              <option label="Falkland Islands" value="object:130">Falkland Islands</option>
                              <option label="Faroe Islands" value="object:131">Faroe Islands</option>
                              <option label="Fiji" value="object:132">Fiji</option>
                              <option label="Finland" value="object:133">Finland</option>
                              <option label="France" value="object:134">France</option>
                              <option label="French Guiana" value="object:135">French Guiana</option>
                              <option label="French Polynesia" value="object:136">French Polynesia</option>
                              <option label="French Southern Territories" value="object:137">French Southern Territories</option>
                              <option label="Gabon" value="object:138">Gabon</option>
                              <option label="Gambia" value="object:139">Gambia</option>
                              <option label="Georgia" value="object:140">Georgia</option>
                              <option label="Germany" value="object:141">Germany</option>
                              <option label="Ghana" value="object:142">Ghana</option>
                              <option label="Gibraltar" value="object:143">Gibraltar</option>
                              <option label="Greece" value="object:144">Greece</option>
                              <option label="Greenland" value="object:145">Greenland</option>
                              <option label="Grenada" value="object:146">Grenada</option>
                              <option label="Guadeloupe" value="object:147">Guadeloupe</option>
                              <option label="Guam" value="object:148">Guam</option>
                              <option label="Guatemala" value="object:149">Guatemala</option>
                              <option label="Guinea" value="object:150">Guinea</option>
                              <option label="Guinea-Bissau" value="object:151">Guinea-Bissau</option>
                              <option label="Guyana" value="object:152">Guyana</option>
                              <option label="Haiti" value="object:153">Haiti</option>
                              <option label="Heard and McDonald Islands" value="object:154">Heard and McDonald Islands</option>
                              <option label="Honduras" value="object:155">Honduras</option>
                              <option label="Hong Kong" value="object:156">Hong Kong</option>
                              <option label="Hungary" value="object:157">Hungary</option>
                              <option label="Iceland" value="object:158">Iceland</option>
                              <option label="India" value="object:159" selected="selected">India</option>
                              <option label="Indonesia" value="object:160">Indonesia</option>
                              <option label="Iran" value="object:161">Iran</option>
                              <option label="Iraq" value="object:162">Iraq</option>
                              <option label="Ireland" value="object:163">Ireland</option>
                              <option label="Israel" value="object:164">Israel</option>
                              <option label="Italy" value="object:165">Italy</option>
                              <option label="Ivory Coast" value="object:166">Ivory Coast</option>
                              <option label="Jamaica" value="object:167">Jamaica</option>
                              <option label="Japan" value="object:168">Japan</option>
                              <option label="Jordan" value="object:169">Jordan</option>
                              <option label="Kazakhstan" value="object:170">Kazakhstan</option>
                              <option label="Kenya" value="object:171">Kenya</option>
                              <option label="Kiribati" value="object:172">Kiribati</option>
                              <option label="Kuwait" value="object:173">Kuwait</option>
                              <option label="Kyrgyzstan" value="object:174">Kyrgyzstan</option>
                              <option label="Laos" value="object:175">Laos</option>
                              <option label="Latvia" value="object:176">Latvia</option>
                              <option label="Lebanon" value="object:177">Lebanon</option>
                              <option label="Lesotho" value="object:178">Lesotho</option>
                              <option label="Liberia" value="object:179">Liberia</option>
                              <option label="Libya" value="object:180">Libya</option>
                              <option label="Liechtenstein" value="object:181">Liechtenstein</option>
                              <option label="Lithuania" value="object:182">Lithuania</option>
                              <option label="Luxembourg" value="object:183">Luxembourg</option>
                              <option label="Macau" value="object:184">Macau</option>
                              <option label="Macedonia" value="object:185">Macedonia</option>
                              <option label="Madagascar" value="object:186">Madagascar</option>
                              <option label="Malawi" value="object:187">Malawi</option>
                              <option label="Malaysia" value="object:188">Malaysia</option>
                              <option label="Maldives" value="object:189">Maldives</option>
                              <option label="Mali" value="object:190">Mali</option>
                              <option label="Malta" value="object:191">Malta</option>
                              <option label="Marshall Islands" value="object:192">Marshall Islands</option>
                              <option label="Martinique" value="object:193">Martinique</option>
                              <option label="Mauritania" value="object:194">Mauritania</option>
                              <option label="Mauritius" value="object:195">Mauritius</option>
                              <option label="Mayotte" value="object:196">Mayotte</option>
                              <option label="Mexico" value="object:197">Mexico</option>
                              <option label="Micronesia" value="object:198">Micronesia</option>
                              <option label="Moldova" value="object:199">Moldova</option>
                              <option label="Monaco" value="object:200">Monaco</option>
                              <option label="Mongolia" value="object:201">Mongolia</option>
                              <option label="Montenegro" value="object:202">Montenegro</option>
                              <option label="Montserrat" value="object:203">Montserrat</option>
                              <option label="Morocco" value="object:204">Morocco</option>
                              <option label="Mozambique" value="object:205">Mozambique</option>
                              <option label="Myanmar" value="object:206">Myanmar</option>
                              <option label="Namibia" value="object:207">Namibia</option>
                              <option label="Nauru" value="object:208">Nauru</option>
                              <option label="Nepal" value="object:209">Nepal</option>
                              <option label="Netherlands" value="object:210">Netherlands</option>
                              <option label="Netherlands Antilles" value="object:211">Netherlands Antilles</option>
                              <option label="New Caledonia" value="object:212">New Caledonia</option>
                              <option label="New Zealand" value="object:213">New Zealand</option>
                              <option label="Nicaragua" value="object:214">Nicaragua</option>
                              <option label="Niger" value="object:215">Niger</option>
                              <option label="Nigeria" value="object:216">Nigeria</option>
                              <option label="Niue" value="object:217">Niue</option>
                              <option label="Norfolk Island" value="object:218">Norfolk Island</option>
                              <option label="North Korea" value="object:219">North Korea</option>
                              <option label="Northern Mariana Islands" value="object:220">Northern Mariana Islands</option>
                              <option label="Norway" value="object:221">Norway</option>
                              <option label="Oman" value="object:222">Oman</option>
                              <option label="Pakistan" value="object:223">Pakistan</option>
                              <option label="Palau" value="object:224">Palau</option>
                              <option label="Panama" value="object:225">Panama</option>
                              <option label="Papua New Guinea" value="object:226">Papua New Guinea</option>
                              <option label="Paraguay" value="object:227">Paraguay</option>
                              <option label="Peru" value="object:228">Peru</option>
                              <option label="Philippines" value="object:229">Philippines</option>
                              <option label="Pitcairn" value="object:230">Pitcairn</option>
                              <option label="Poland" value="object:231">Poland</option>
                              <option label="Portugal" value="object:232">Portugal</option>
                              <option label="Puerto Rico" value="object:233">Puerto Rico</option>
                              <option label="Qatar" value="object:234">Qatar</option>
                              <option label="Reunion" value="object:235">Reunion</option>
                              <option label="Romania" value="object:236">Romania</option>
                              <option label="Russian Federation" value="object:237">Russian Federation</option>
                              <option label="Rwanda" value="object:238">Rwanda</option>
                              <option label="S. Georgia and S. Sandwich Islands" value="object:239">S. Georgia and S. Sandwich Islands</option>
                              <option label="Saint Kitts and Nevis" value="object:240">Saint Kitts and Nevis</option>
                              <option label="Saint Lucia" value="object:241">Saint Lucia</option>
                              <option label="Saint Vincent and The Grenadines" value="object:242">Saint Vincent and The Grenadines</option>
                              <option label="Samoa" value="object:243">Samoa</option>
                              <option label="San Marino" value="object:244">San Marino</option>
                              <option label="Sao Tome and Principe" value="object:245">Sao Tome and Principe</option>
                              <option label="Saudi Arabia" value="object:246">Saudi Arabia</option>
                              <option label="Senegal" value="object:247">Senegal</option>
                              <option label="Serbia" value="object:248">Serbia</option>
                              <option label="Seychelles" value="object:249">Seychelles</option>
                              <option label="Sierra Leone" value="object:250">Sierra Leone</option>
                              <option label="Singapore" value="object:251">Singapore</option>
                              <option label="Slovakia" value="object:252">Slovakia</option>
                              <option label="Slovenia" value="object:253">Slovenia</option>
                              <option label="Solomon Islands" value="object:254">Solomon Islands</option>
                              <option label="Somalia" value="object:255">Somalia</option>
                              <option label="South Africa" value="object:256">South Africa</option>
                              <option label="South Korea" value="object:257">South Korea</option>
                              <option label="Soviet Union" value="object:258">Soviet Union</option>
                              <option label="Spain" value="object:259">Spain</option>
                              <option label="Sri Lanka" value="object:260">Sri Lanka</option>
                              <option label="St. Helena" value="object:261">St. Helena</option>
                              <option label="St. Pierre and Miquelon" value="object:262">St. Pierre and Miquelon</option>
                              <option label="Sudan" value="object:263">Sudan</option>
                              <option label="Suriname" value="object:264">Suriname</option>
                              <option label="Svalbard and Jan Mayen Islands" value="object:265">Svalbard and Jan Mayen Islands</option>
                              <option label="Swaziland" value="object:266">Swaziland</option>
                              <option label="Sweden" value="object:267">Sweden</option>
                              <option label="Switzerland" value="object:268">Switzerland</option>
                              <option label="Syria" value="object:269">Syria</option>
                              <option label="Taiwan" value="object:270">Taiwan</option>
                              <option label="Tajikistan" value="object:271">Tajikistan</option>
                              <option label="Tanzania" value="object:272">Tanzania</option>
                              <option label="Thailand" value="object:273">Thailand</option>
                              <option label="Timor-Leste" value="object:274">Timor-Leste</option>
                              <option label="Togo" value="object:275">Togo</option>
                              <option label="Tokelau" value="object:276">Tokelau</option>
                              <option label="Tonga" value="object:277">Tonga</option>
                              <option label="Trinidad and Tobago" value="object:278">Trinidad and Tobago</option>
                              <option label="Tunisia" value="object:279">Tunisia</option>
                              <option label="Turkey" value="object:280">Turkey</option>
                              <option label="Turkmenistan" value="object:281">Turkmenistan</option>
                              <option label="Turks and Caicos Islands" value="object:282">Turks and Caicos Islands</option>
                              <option label="Tuvalu" value="object:283">Tuvalu</option>
                              <option label="Uganda" value="object:284">Uganda</option>
                              <option label="Ukraine" value="object:285">Ukraine</option>
                              <option label="United Arab Emirates" value="object:286">United Arab Emirates</option>
                              <option label="United Kingdom" value="object:287">United Kingdom</option>
                              <option label="United States" value="object:288">United States</option>
                              <option label="Uruguay" value="object:289">Uruguay</option>
                              <option label="US Minor Outlying Islands" value="object:290">US Minor Outlying Islands</option>
                              <option label="US Virgin Islands" value="object:291">US Virgin Islands</option>
                              <option label="Uzbekistan" value="object:292">Uzbekistan</option>
                              <option label="Vanuatu" value="object:293">Vanuatu</option>
                              <option label="Venezuela" value="object:294">Venezuela</option>
                              <option label="Viet Nam" value="object:295">Viet Nam</option>
                              <option label="Wallis and Futuna Islands" value="object:296">Wallis and Futuna Islands</option>
                              <option label="Western Sahara" value="object:297">Western Sahara</option>
                              <option label="Yemen" value="object:298">Yemen</option>
                              <option label="Yugoslavia" value="object:299">Yugoslavia</option>
                              <option label="Zaire" value="object:300">Zaire</option>
                              <option label="Zambia" value="object:301">Zambia</option>
                              <option label="Zimbabwe" value="object:302">Zimbabwe</option>
                            </select>
                            <label for="country" style="color: black !important" class="active">Country *</label>
                        </div>

                        <div class="input-field col s6 mb-3">
                            <select id="state" name="state">
                              <option value="" class="" selected="selected"></option>
                              <option label="Andaman and Nicobar Islands" value="string:AN">Andaman and Nicobar Islands</option>
                              <option label="Andhra Pradesh" value="string:AP">Andhra Pradesh</option>
                              <option label="Arunachal Pradesh" value="string:AR">Arunachal Pradesh</option>
                              <option label="Assam" value="string:AS">Assam</option>
                              <option label="Bihar" value="string:BR">Bihar</option>
                              <option label="Chandigarh" value="string:CH">Chandigarh</option>
                              <option label="Chhattisgarh" value="string:CT">Chhattisgarh</option>
                              <option label="Dadra and Nagar Haveli" value="string:DN">Dadra and Nagar Haveli</option>
                              <option label="Daman and Diu" value="string:DD">Daman and Diu</option>
                              <option label="Delhi" value="string:DL">Delhi</option>
                              <option label="Goa" value="string:GA">Goa</option>
                              <option label="Gujarat" value="string:GJ">Gujarat</option>
                              <option label="Haryana" value="string:HR">Haryana</option>
                              <option label="Himachal Pradesh" value="string:HP">Himachal Pradesh</option>
                              <option label="Jammu and Kashmir" value="string:JK">Jammu and Kashmir</option>
                              <option label="Jharkhand" value="string:JH">Jharkhand</option>
                              <option label="Karnataka" value="string:KA">Karnataka</option>
                              <option label="Kerala" value="string:KL">Kerala</option>
                              <option label="Lakshadweep" value="string:LD">Lakshadweep</option>
                              <option label="Madhya Pradesh" value="string:MP">Madhya Pradesh</option>
                              <option label="Maharashtra" value="string:MH" selected="selected">Maharashtra</option>
                              <option label="Manipur" value="string:MN">Manipur</option>
                              <option label="Meghalaya" value="string:ML">Meghalaya</option>
                              <option label="Mizoram" value="string:MZ">Mizoram</option>
                              <option label="Nagaland" value="string:NL">Nagaland</option>
                              <option label="Orissa" value="string:OR">Orissa</option>
                              <option label="Puducherry" value="string:PY">Puducherry</option>
                              <option label="Punjab" value="string:PB">Punjab</option>
                              <option label="Rajasthan" value="string:RJ">Rajasthan</option>
                              <option label="Sikkim" value="string:SK">Sikkim</option>
                              <option label="Tamil Nadu" value="string:TN">Tamil Nadu</option>
                              <option label="Telangana State (TS)" value="string:TG">Telangana State (TS)</option>
                              <option label="Tripura" value="string:TR">Tripura</option>
                              <option label="Uttar Pradesh" value="string:UP">Uttar Pradesh</option>
                              <option label="Uttarakhand" value="string:UL">Uttarakhand</option>
                              <option label="West Bengal" value="string:WB">West Bengal</option>
                            </select>
                            <label for="state" class="active">State *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="name" name="name">
                            <label for="name" class="active">Contact Person *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="phone" name="phone">
                            <label for="phone" class="active">Phone</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="fax" name="fax">
                            <label for="fax" class="active">Fax</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="website" name="website">
                            <label for="website" class="active">Website</label>
                        </div>
                        
                        <div class="input-field col mb-4">
                            <input type="file" id="photo" class="mt-3" name="photo">
                            <label for="photo" class="active">Photo</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="pan_no" name="pan_no">
                            <label for="pan_no" class="active">PAN *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="aadhar_no" name="aadhar_no">
                            <label for="aadhar_no" class="active">AADHAR No *</label>
                        </div>

                        <div class="input-field col">
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" id="gst_number" name="gst_number">
                                    <label for="gst_number" class="active">GSTIN *</label>
                                </div>
                                <div class="col-md-1">
                                    <a href="https://services.gst.gov.in/services/searchtp">
                                        <img src="https://omninxg-stage.aspirtek.com/OMNI/Portals/0/fa-icons/16/search.png">
                                    </a>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" id="annual_turnover" name="annual_turnover">
                                    <label for="annual_turnover" class="active">Annual Turnover</label>
                                </div>
                            </div>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="reference_name1" name="reference_name1">
                            <label for="reference_name1" class="active">Reference Name 1</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="reference_name2" name="reference_name2">
                            <label for="reference_name2" class="active">Reference Name 2</label>
                        </div>

                    </div>

                    <div class="col-md-12">
                        <div class="input-field col">
                            <a class="btn btn-primary" onclick="myFunction()" style="color:#fff" id="reset-form">Cancel</a> 
                            <button type="submit" name="submit" class="btn btn-primary float-right">Update</button> 
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 5px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                  <div class="col-md-12">
                        <div class="input-field col mb-3">
                            <select class="validate ipdis" id="vendor_type" name="vendor_type">
                              <option value="" class=""></option>
                              <option label="Supplier">Supplier</option>
                              <option label="Sub-Contractor">Sub-Contractor</option>
                              <option label="PRW">PRW</option>
                              <option label="Recruiting Agency">Recruiting Agency</option>
                              <option label="Mobile Service">Mobile Service</option>
                              <option label="Others">Others</option>
                              <option label="Both Supplier-SubCon">Both Supplier-SubCon</option>
                              <option label="RNM Vendor">RNM Vendor</option>
                              <option label="Charity Beneficiary">Charity Beneficiary</option>
                              <option label="Property Administrator">Property Administrator</option>
                              <option label="Property Owner">Property Owner</option>
                              <option label="Consultant">Consultant</option>
                              <option label="Transporter">Transporter</option>
                              <option label="Related Party">Related Party</option>
                            </select>
                            <label for="vendor_type" style="color: black !important" class="active">Type *</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-field col s6 mb-3">
                            <select class="validate ipdis" id="category" name="vendor_type">
                              <option value="" class=""></option>
                              @foreach($category as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                              @endforeach
                            </select>
                            <label for="vendor_type" style="color: black !important" class="active">Item Category *</label>
                        </div>

                        <div class="input-field col s6 mb-3">
                            <select class="validate ipdis" id="subcategory" name="vendor_type" disabled="">
                              <option value="" class=""></option>
                              @foreach($subcategory as $subcat)
                                <option label="{{ $subcat->category_id }}" value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                              @endforeach
                            </select>
                            <label for="vendor_type" style="color: black !important" class="active">Item Subcategory *</label>
                        </div>

                        <div class="input-field col mb-3">
                            <select class="validate ipdis" id="items" name="vendor_type" disabled="">
                              <option value="" class=""></option>
                              @foreach($items as $item)
                                <option label="{{ $item->brand }}" value="{{ $item->id }}">{{ $item->title }}</option>
                              @endforeach
                            </select>
                            <label for="vendor_type" style="color: black !important" class="active">Item Name *</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary float-right">Update</button> 
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="BankDetails" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 5px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-field col">
                            <input type="text" id="account_holder_name" name="account_holder_name">
                            <label for="account_holder_name" class="active">Account Holder Name *</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-field col s6">
                            <input type="text" id="bank_name" name="bank_name">
                            <label for="bank_name" class="active">Bank Name *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="bank_branch" name="bank_branch">
                            <label for="bank_branch" class="active">Bank Branch *</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-field col s6">
                            <input type="text" id="bank_account_no" name="bank_account_no">
                            <label for="bank_account_no" class="active">Account Number *</label>
                        </div>

                        <div class="input-field col s6">
                            <input type="text" id="bank_ifsc_code" name="bank_ifsc_code">
                            <label for="bank_ifsc_code" class="active">IFSC Code *</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="input-field col">
                            <input type="text" id="bank_address" name="bank_address">
                            <label for="bank_address" class="active">Address *</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" class="btn btn-primary float-right">Update</button> 
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
      var $optgroups = $('#subcategory > option');
      $("#category").on("change",function(){
        var selectedVal = this.value;
        $('#subcategory').removeAttr("disabled");
        $('#subcategory').html($optgroups.filter('[label="'+selectedVal+'"]'));
      });  

      var $opt = $('#items > option');
      $("#subcategory").on("change",function(){
        var selectedValue = this.value;
        $('#items').removeAttr("disabled");
        $('#items').html($opt.filter('[label="'+selectedValue+'"]'));
      });  
  });
</script>

<script type="text/javascript">
    function myFunction() {
      document.getElementById("myForm").reset();
    }
</script>