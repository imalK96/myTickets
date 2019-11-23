
function formvalidate()
{
    var username = document.getElementById('username');
    var email = document.getElementById('email');
    var contact = document.getElementById('contact');
    var password1 = document.getElementById('password1');
    var password2 = document.getElementById('password2');


    if(validateUser(username))
    {
        if(validEmail(email))
        {
            if(validContact(contact))
            {
                if(validPassword(password1))
                {
                    if(passwordMatch(password1,password2))
                    {
                        return true;
                    }
                
                }
           
            }
        }
        
    
    }
  
    return false;


}

function validateUser(inputtext)
{
    var alphaExp = /^[a-zA-Z]+$/;
    if(inputtext.value.match(alphaExp)){
    return true;
    }else{
    document.getElementById('u_error').innerText = "Enter a valid Name" ;
   inputtext.focus();
    return false;
    }
}

function validEmail(inputtext)
{
    var emailExp = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if(inputtext.value.match(emailExp)){
    return true;
    }else{
    document.getElementById('e_error').innerText = "Enter a valid email address";
    inputtext.focus();
    return false;
    }
   
}

function validContact(inputtext)
{
    var numericExpression = /^[0-9]+$/;
    if(inputtext.value.match(numericExpression)){
    return true;
    }else
    {
        document.getElementById('c_error').innerText = "Enter a valid contact number";
        inputtext.focus();
        return false;
    }

}

function passwordMatch(pass1,pass2)
{
    if(pass1.value==pass2.value)
    {
        return true;
    }

    else
    {
        document.getElementById('p1_error').innerText = "Passwords does not match";
        document.getElementById('p2_error').innerText = "Passwords does not match";

        pass1.focus();
        return false;
    }

}

function validPassword(inputtext)
{
    
        var alphaExp = /^[0-9a-zA-Z]+$/;

        if(inputtext.value.match(alphaExp))
        {
            return true;
        }
        else
        {
            document.getElementById('p1_error').innerText = "Password must contain charachters and numbers";
            inputtext.focus();
            return false;
        }
       
}

function loginValidate()
{
    var email = document.getElementById('email');
    var password = document.getElementById('password');

    if(validEmail(email))
    {
        if(checkEmail(email))
        {
            if(checkEmailPassword(email,password))
            {

                window.location.href="home.html";
                
            }
               
        }
        
    }

    return false;
}

function checkEmail(email)
{
    if(email.value=='admin@abc.lk')
    {
        return true;
    }
    else
    {
        document.getElementById('e_error').innerText = "Email address not registered";
        email.focus();
        return false;

    }
}

function checkEmailPassword(email,password)
{
    if(email.value=='admin@abc.lk' && password.value=='123')
    {
        return true;
    }
    else
    {
        alert("Invalid email or password");

        document.getElementById('e_error').innerText = "Check Email";
        document.getElementById('p_error').innerText = "Check Password";
        return false;
    }
}

function formPaymentValid()
{
    var pmethod = document.getElementById('pmthod');
    var cvv = document.getElementById('pmthod');
    

    if(trueSelection(pmethod))
    {
        if(validCvv(cvv)){

        }
    }

    return false;
}

function trueSelection(inputtext){
    if(inputtext.value == 'Select Payment Method')
    {
        document.getElementById('pm_error').innerText = "Please Select a payment method";
        inputtext.focus();
        return false;
    }
    else
    {
    return true;
    }
   }

   function validCvv(inputtext)
   {
       var numericExpression = /^[0-9]+$/;
       if(inputtext.value.match(numericExpression)){
       return true;
       }else
       {
           document.getElementById('cvv_error').innerText = "Enter a valid CVV number. Check the bank of your card";
           inputtext.focus();
           return false;
       }
   
   }
   


