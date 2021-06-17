<form action="/user/handle/sign-up" method="post">
    <input type="text" name="nick" placeholder="Nickname" pattern="[a-Z].*{2,}" required/>
    <input type="email" name="email" placeholder="E-mail" required/>
    <input type="password" name="password" placeholder="Password" required/>
    <input type="password" name="confirmPassword" placeholder="Confirm Password" required/>
    <input type="submit" value="Register"/>
</form>