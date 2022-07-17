<!-- Modal -->
<div class="modal fade" id="user_profile_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">User Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="mdc-layout-grid mb-1">
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                    <img width="100px" height="100px" src="../assets/images/faces/face1.jpg" alt="user"
                         class="user rounded">
                </div>
            </div>

            <form id="changeProfile">
                <div class="modal-body">

                    <div class="mdc-layout-grid">
                        <div class="mdc-layout-grid__inner">

                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                <div class="mdc-text-field w-100">

                                    <input type="file" name="profile_pic" id="profile_pic"
                                           class="mdc-text-field__input">
                                    <label for="profile_pic"><small>Profile Pic</small></label>
                                </div>
                            </div>

                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                <div class="mdc-text-field w-100">
                                    <input type="text" class="mdc-text-field__input" id="fname" name="efname" required value="<?= $logged_user['fname'] ?>">
                                    <div class="mdc-line-ripple"></div>
                                    <label for="fname" class="mdc-floating-label">First name</label>
                                </div>
                            </div>
                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">
                                <div class="mdc-text-field w-100">
                                    <input type="text" class="mdc-text-field__input" id="lname" name="elname" required value="<?= $logged_user['lname'] ?>">
                                    <div class="mdc-line-ripple"></div>
                                    <label for="lname" class="mdc-floating-label">Last name</label>
                                </div>
                            </div>

                            <div class="mdc-layout-grid__cell stretch-card  mdc-layout-grid__cell--span-6-desktop">
                                <div class="mdc-text-field w-100">
                                    <input class="mdc-text-field__input" type="tel" name="ephone" id="phone" required value="<?= $logged_user['phone'] ?>">
                                    <div class="mdc-line-ripple"></div>
                                    <label for="phone" class="mdc-floating-label">Phone</label>
                                </div>
                            </div>

                            <div class="mdc-layout-grid__cell stretch-card  mdc-layout-grid__cell--span-6-desktop">
                                <div class="mdc-text-field w-100">
                                    <input class="mdc-text-field__input" type="email" name="eemail" id="email" required value="<?= $logged_user['email'] ?>">
                                    <div class="mdc-line-ripple"></div>
                                    <label for="email" class="mdc-floating-label">Email</label>
                                </div>
                            </div>
                            <div class="mdc-layout-grid__cell stretch-card  mdc-layout-grid__cell--span-12">
                                <div class="mdc-text-field w-100">
                                    <input class="mdc-text-field__input" type="password" id="password" name="password" autocomplete="off">
                                    <div class="mdc-line-ripple"></div>
                                    <label for="password" class="mdc-floating-label">Password</label>
                                </div>
                            </div>

                            <div class="mdc-layout-grid__cell stretch-card  mdc-layout-grid__cell--span-12">
                                <div class="mdc-text-field w-100">
                                    <textarea class="mdc-text-field__input" id="address" name="eaddress" required><?= $logged_user['address'] ?></textarea>
                                    <div class="mdc-line-ripple"></div>
                                    <label for="address" class="mdc-floating-label">Address</label>
                                </div>
                            </div>

                            <input type="hidden" id="user_id" name="euser_id" value="<?= $logged_user['user_id'] ?>" />

                            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                                <button id="loginBtn" type="submit" class="mdc-button mdc-button--raised w-100">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>

<!--<footer>-->
<!--    <div class="mdc-layout-grid">-->
<!--        <div class="mdc-layout-grid__inner">-->
<!--            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop">-->
<!--                            <span class="text-center text-sm-left d-block d-sm-inline-block tx-14">Copyright © <a-->
<!--                                    href="https://www.bootstrapdash.com/" target="_blank">bootstrapdash.com </a>2020</span>-->
<!--            </div>-->
<!--            <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6-desktop d-flex justify-content-end">-->
<!--                            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center tx-14">Free <a-->
<!--                                    href="https://www.bootstrapdash.com/material-design-dashboard/" target="_blank"> material admin </a> dashboards from Bootstrapdash.com</span>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</footer>-->
