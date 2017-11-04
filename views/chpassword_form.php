<div class='main'>
    <div id='incontent'>
        <form action="chpassword.php" method="post">
            <div class="form-group">
                <input style="width:300px;" autocomplete="off" class="form-control" name="username" placeholder="Username" type="text"/>
            </div>
            <div class="form-group">
                <input style="width:300px;" class="form-control" name="old_password" placeholder="Old Password" type="password"/>
            </div>
            <div class="form-group">
                <input style="width:300px;" class="form-control" name="new_password" placeholder="New Password" type="password"/>
            </div>
            <div class="form-group">
                <input style="width:300px;" class="form-control" name="confirmation" placeholder="Confirm New Password" type="password"/>
            </div>
            <div class="form-group">
                <button class="btn btn-default" type="submit">
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>