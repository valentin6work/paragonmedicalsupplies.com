<?php
/**
 * Template Name: Company Registration
 *
 *
 */
get_header();

$contact_info = get_field('contact_info',get_the_ID());
$form_data = get_field('form_data',get_the_ID());

?>
<!-- [ <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>  -->

<div class="wrapper">
    <main class="page">
        <section class="company-reg-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 offset-0 offset-lg-2 col-lg-8">

                        <h1><?php the_title();?></h1>
                        <form class="company-reg form__input-style white-bg" action="#" method="post">
                            <input type="hidden" name="action" value="submit_company_form">

                            <h4>Company Information</h4>
                            <div class="company-info__input-wrapper company-inform__block">
                                <div class="form__input">
                                    <label for="companyName">Company Name<span class="red__star">*</span></label>
                                    <input type="text" name="companyName" id="companyName" placeholder="Company Name" required>
                                </div>
                                <div class="form__input">
                                    <label for="companyLegName">Company Legal Name</label>
                                    <input type="text" name="companyLegName" id="companyLegName" placeholder="Company Legal Name">
                                </div>
                                <div class="form__input">
                                    <label for="compInfStrAd">Street Address<span class="red__star">*</span></label>
                                    <input type="text" name="compInfStrAd" id="compInfStrAd" placeholder="Street Address" required>
                                </div>
                                <div class="form__input">
                                    <label for="vatId">VAT/TAX ID</label>
                                    <input type="text" name="vatId" id="vatId" placeholder="Apt, suite, unit, floor">
                                </div>
                                <div class="form__input form__input-full-width">
                                    <label for="ReSellerId">Re-seller ID</label>
                                    <input type="tel" name="ReSellerId" id="ReSellerId" placeholder="Phone Number">
                                </div>
                            </div>
                            <h4>Legal Address</h4>
                            <div class="company-info__input-wrapper legal-address__block">
                                <div class="form__input form__input-full-width">
                                    <label for="legAddressPhone">Phone Number<span class="red__star">*</span></label>
                                    <input type="tel" name="legAddressPhone" id="legAddressPhone" placeholder="Phone Number" required>
                                </div>
                                <div class="form__input">
                                    <label for="legAddressStrAd">Street Address<span class="red__star">*</span></label>
                                    <input type="text" name="legAddressStrAd" id="legAddressStrAd" placeholder="Street Address" required>
                                </div>
                                <div class="form__input">
                                    <label for="addressDet">Address Details</label>
                                    <input type="text" name="addressDet" id="addressDet" placeholder="Apt, suite, unit, floor">
                                </div>
                                <div class="form__input form__input-full-width">
                                    <label for="citySelect">City<span class="red__star">*</span></label>
                                    <select id="citySelect" class="js-example-basic-single" required>
                                        <option value="" selected>Select city</option>
                                        <option value="Atlanta">Atlanta</option>
                                        <option value="Austin">Austin</option>
                                        <option value="Boston">Boston</option>
                                        <option value="Chicago">Chicago</option>
                                        <option value="Dallas">Dallas</option>
                                        <option value="Denver">Denver</option>
                                        <option value="Detroit">Detroit</option>
                                        <option value="Houston">Houston</option>
                                        <option value="Las Vegas">Las Vegas</option>
                                        <option value="Los Angeles">Los Angeles</option>
                                        <option value="Miami">Miami</option>
                                        <option value="New Orleans">New Orleans</option>
                                        <option value="New York">New York</option>
                                        <option value="Philadelphia">Philadelphia</option>
                                        <option value="Phoenix">Phoenix</option>
                                        <option value="San Antonio">San Antonio</option>
                                        <option value="San Diego">San Diego</option>
                                        <option value="San Francisco">San Francisco</option>
                                        <option value="Seattle">Seattle</option>
                                        <option value="Washington, D.C.">Washington, D.C.</option>
                                    </select>
                                </div>
                                <div class="form__input">
                                    <label for="zipCode">ZIP Code<span class="red__star">*</span></label>
                                    <input type="text" name="zipCode" id="zipCode" placeholder="ZIP Code" required>
                                </div>
                                <div class="form__input">
                                    <label for="stateSelect">State<span class="red__star">*</span></label>
                                    <select id="stateSelect" class="js-example-basic-single" required>
                                        <option value="" selected>Select state</option>
                                        <option value="Alabama">Alabama</option>
                                        <option value="Alaska">Alaska</option>
                                        <option value="Arizona">Arizona</option>
                                        <option value="Arkansas">Arkansas</option>
                                        <option value="California">California</option>
                                        <option value="Colorado">Colorado</option>
                                        <option value="Connecticut">Connecticut</option>
                                        <option value="Delaware">Delaware</option>
                                        <option value="Florida">Florida</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Hawaii">Hawaii</option>
                                        <option value="Idaho">Idaho</option>
                                        <option value="Illinois">Illinois</option>
                                        <option value="Indiana">Indiana</option>
                                        <option value="Iowa">Iowa</option>
                                        <option value="Kansas">Kansas</option>
                                        <option value="Kentucky">Kentucky</option>
                                        <option value="Louisiana">Louisiana</option>
                                        <option value="Maine">Maine</option>
                                        <option value="Maryland">Maryland</option>
                                        <option value="Massachusetts">Massachusetts</option>
                                        <option value="Michigan">Michigan</option>
                                        <option value="Minnesota">Minnesota</option>
                                        <option value="Mississippi">Mississippi</option>
                                        <option value="Missouri">Missouri</option>
                                        <option value="Montana">Montana</option>
                                        <option value="Nebraska">Nebraska</option>
                                        <option value="Nevada">Nevada</option>
                                        <option value="New Hampshire">New Hampshire</option>
                                        <option value="New Jersey">New Jersey</option>
                                        <option value="New Mexico">New Mexico</option>
                                        <option value="New York">New York</option>
                                        <option value="North Carolina">North Carolina</option>
                                        <option value="North Dakota">North Dakota</option>
                                        <option value="Ohio">Ohio</option>
                                        <option value="Oklahoma">Oklahoma</option>
                                        <option value="Oregon">Oregon</option>
                                        <option value="Pennsylvania">Pennsylvania</option>
                                        <option value="Rhode Island">Rhode Island</option>
                                        <option value="South Carolina">South Carolina</option>
                                        <option value="South Dakota">South Dakota</option>
                                        <option value="Tennessee">Tennessee</option>
                                        <option value="Texas">Texas</option>
                                        <option value="Utah">Utah</option>
                                        <option value="Vermont">Vermont</option>
                                        <option value="Virginia">Virginia</option>
                                        <option value="Washington">Washington</option>
                                        <option value="West Virginia">West Virginia</option>
                                        <option value="Wisconsin">Wisconsin</option>
                                        <option value="Wyoming">Wyoming</option>
                                    </select>
                                </div>
                            </div>
                            <h4>Company Administrator</h4>
                            <div class="company-info__input-wrapper company-admin__block">
                                <div class="form__input">
                                    <label for="jobTitle">Job Title</label>
                                    <input type="text" name="jobTitle" id="jobTitle" placeholder="Job Title">
                                </div>
                                <div class="form__input">
                                    <label for="compAdminMail">Email<span class="red__star">*</span></label>
                                    <input type="email" name="compAdminMail" id="compAdminMail" placeholder="Email" required>
                                </div>
                                <div class="form__input">
                                    <label for="firstNameAdmin">First Name<span class="red__star">*</span></label>
                                    <input type="text" name="firstNameAdmin" id="firstNameAdmin" placeholder="First Name" required>
                                </div>
                                <div class="form__input">
                                    <label for="lastNameAdmin">Last Name<span class="red__star">*</span></label>
                                    <input type="text" name="lastNameAdmin" id="lastNameAdmin" placeholder="Last Name" required>
                                </div>
                            </div>
                            <button type="submit" class="btn-main btn-large">Confirm information</button>
                        </form>
                        <div class="form__error"></div>
                        <div class="form__success"></div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>

<!--  <?php  echo str_replace($_SERVER['DOCUMENT_ROOT'],'',__FILE__); ?>]  -->
<?php
get_footer();
?>