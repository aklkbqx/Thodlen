<footer class="bg-white mt-2 min-width-container">
    <div class="container p-4 min-width-container">
        <div class="w-100 d-flex justify-content-between">
            <div class="d-flex flex-column">
                <h4><?php echo $web_name_var; ?></h4>
                <div class="d-flex align-items-center mt-2" style="gap:10px">
                    <i class="fa-solid fa-location-dot text-cyan"></i>
                    <p class="text-dark"><?php echo $address_var; ?></p>
                </div>
                <div class="d-flex align-items-center mt-2" style="gap:10px">
                    <i class="fa-solid fa-phone text-cyan"></i>
                    <p class="text-dark"><?php echo $telephone_var; ?></p>
                </div>
                <div class="d-flex align-items-center mt-2" style="gap:10px">
                    <i class="fa-solid fa-envelope text-cyan"></i>
                    <p class="text-dark"><?php echo $email_var; ?></p>
                </div>
            </div>
            <div class="d-flex flex-column">
                <h4>ติดตามข่าวสารจากเรา</h4>
                <form action="" method="post" class="d-flex align-items-center mt-2" style="gap:10px">
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">ที่อยู่อีเมล</label>
                    </div>
                    <button class="btn btn-cyan rounded-3 fs-4" type="submit" name="subscribe" style="height: 58px;">ติดตาม</button>
                </form>
            </div>
        </div>
    </div>
    <div class="border-top w-100 p-4">
        <div class="d-flex justify-content-center">
            <?php echo $copyright_text_var; ?>
        </div>
    </div>
</footer>