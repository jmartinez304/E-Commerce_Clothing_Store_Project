<?php
require 'selection_header.php';
?>

    <div class="sec1-checkout">
        <div class="sec-animate">
            <span class="title2">Checkout</span>
            <hr class="one">

            <form action="receipt.php" method="post">
                <div class="container-Fields form-group">
                    <!--  First Name Field -->
                    <div style="display: inline-block;">
                        <label for="firstName">First Name</label><br>
                        <input class="checkout-Input" type="text" id="firstName" name="firstName"
                               placeholder="e.g., John" required>
                    </div>

                    <!--  Last Name Field -->
                    <div style="display: inline-block;">
                        <label for="lastName">Last Name</label><br>
                        <input class="checkout-Input" type="text" id="lastName" name="lastName" placeholder="e.g., Doe"
                               required>
                    </div>
                    <br><br>

                    <!--  Email Field -->
                    <div style="display: inline-block;">
                        <label for="email">Email:</label><br>
                        <input class="checkout-Input" type="email" id="email" name="email"
                               placeholder="e.g., john@email.com" required>
                    </div>

                    <!-- Phone Number Field -->
                    <div style="display: inline-block;">
                        <label for="phoneNumber">Phone Number (Only numbers)</label><br>
                        <input class="checkout-Input" type="text" pattern="[0-9]{10}" id="phoneNumber"
                               name="phoneNumber" placeholder="e.g., 4078485236" required>
                    </div>
                    <br><br>

                    <!-- Address Field -->
                    <div style="display: inline-block;">
                        <label for="address">Address</label><br>
                        <input class="checkout-Input" style="width: 645px;" type="text" id="address" name="address"
                               placeholder="e.g., 701 N Econlockhatchee Trail" required>
                    </div>
                    <br><br>

                    <!-- City Field -->
                    <div style="display: inline-block;">
                        <label for="city">City</label><br>
                        <input class="checkout-Input" type="text" id="city" name="city" placeholder="e.g., Orlando"
                               required>
                    </div>

                    <!-- State Or Region Field -->
                    <div style="display: inline-block;">
                        <label for="region">State Or Region</label><br>
                        <select class="checkout-Input" id="region" name="region" required>
                            <option disabled selected value> -- Select an Option --</option>
                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="DC">District Of Columbia</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                    <br><br>

                    <!-- Country Field -->
                    <div style="display: inline-block;">
                        <label for="region">Country</label><br>
                        <input class="checkout-Input" id="country" name="country" value="United States" readonly>
                    </div>

                    <!-- Postal Code Field -->
                    <div style="display: inline-block;">
                        <label for="postalCode">Postal Code (U.S. postal code only)</label><br>
                        <input class="checkout-Input" type="tel" pattern="[0-9]{5}" id="postalCode" name="postalCode"
                               placeholder="e.g., 32825" required>
                    </div>
                    <br><br><br><br>

                    <h3 style="color: black;">Our services are only available in the United States, but we are working
                        on expanding our services to other countries.</h3>

                    <!-- Input Button -->
                    <input class="submitButton" name="place_order" type="submit" value="Place Order">
                </div>
            </form>
        </div>
    </div>

    <a href="javascript:" id="return-to-top"><i class="fa fa-angle-double-up"></i></a>

<?php
require 'footer.php';
?>