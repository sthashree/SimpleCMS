// JavaScript Document

/* 
##########Author Prabeen Giri prabeengiri.com.np" CopyRight Prabeen Giri #########################
Build Date: Feb-6-2009 , I worked for almost 3 days to make it  complete.It is tested on Firefox and IE

Functions  =  Validates the form , check whether the field is empty or not, if the value is number and if email address is valid or not and password confirmation
How to Use: 1.Just give id = 'prabeen' to the form to be validated 
              Give class Name = 'required' if the value of the field should not be empty 
			  Give class = 'confirm' to confirm the two passwords ;
			  Give class='number' to check if the entered value is number.
			  Give class='validate' to validate  email
			  Give class = 'image' to check the extension of selected file.
			 
			  Just insert these className inside the 'input' tag , or 'select' tag or 'file' tag 
###########################################################################                  

*/
//creates the new element 'span' with the 
var cssRequired = "color:#DF3A00;padding-right:3px;width:200px;font-style:italic; align:right;";
var cssNotValid = "color:#DF3A00;padding-right:3px;width:200px;font-style:italic;";
var cssNumber =  "color:#DF3A00;padding-right:3px;width:200px;font-style:italic;"; 
var cssConfirm =  "color:#DF3A00;padding-right:3px;width:200px;font-style:italic;";
var cssNoImage =  "color:#DF3A00;padding-right:3px;width:200px;font-style:italic;";


var txtNoImage = "Not Image File"
var textReq = "Required" ; 
var textCofirm = "Password Not Matched";
var textNotValid = "Not Valid Email" ; 
var textNumber  =  "Not Number"; 

function createSpan(css,text)
{
    var sp = document.createElement("span");
    sp.setAttribute('id',"neelam"); 
    
    sp.style.cssText=css;
    sp.innerHTML=text; 
    return sp;
}
//this function is called when user clicks the button
function checkValue(frm) 
{ 
    stat = false; 
	var password  = new Array();
	//alert(frm.length);
    for(var i=0; i < frm.length;i++)
    {     
       
		var el = frm.elements[i]; 
       
	   var className = (el.className); 
	   //alert(className);
        //to check if the there is more than one class on that input field;
       
	   
	   if (className.match([" "]))
        { 
            className = checkClassName(className); 
        } 
        
		if (className == "required" || className == "validate" || className == "number" || className =='confirm')
		{ 
		//this function checks the class name and does the respective action 
        	showResultAccordingTotheClassName(el , className);
		}
	   if (el.type == "checkbox" && className =="required")
		{ 
			processCheckBox(el);
		}
	   if (el.type == "password" && className =="confirm")
		{ 
			password.push(el.value); 
			password.push(el); 
			processConfirmPassword(password);
		}
		if(el.type =="file" && className =="image") 
		{ 
			checkImage(el); 
		} 
    }
    //stop submitting the form if there if it is not valid 
    if (stat) 
    { 
        return false; 
    } 
} 
function processConfirmPassword(pass)
{ 
	if (pass.length == 4)
	{ 
		
		if (pass[0]== "" && pass[2]== "")
		{ 
			if(pass[1]. parentNode.lastChild.id != "neelam")
			{ 
				cs= cssRequired; 
				txt = textReq ;
				append(pass[1],createSpan(cs ,txt));
			}
			if(pass[3]. parentNode.lastChild.id != "neelam")
			{ 
				cs= cssRequired; 
				txt = textReq ;
				append(pass[3],createSpan(cs ,txt));
			}
			stat = true; 
		} 
		else
		{ 
			if (pass[0] != pass[2])
			{ 
				if(pass[1].parentNode.lastChild.id != "neelam")
					{ 
						
						cs= cssConfirm;
						txt = textCofirm;
						append(pass[1],createSpan(cs,txt));
					}
					if(pass[3].parentNode.lastChild.id != "neelam")
					{ 
						
						cs= cssConfirm;
						txt = textCofirm;
						append(pass[3],createSpan(cs,txt));
					}
					stat = true; 
			} 
		}
	} 
} 
function processCheckBox(checkNode)
{ 
	 if (checkNode.checked == false)
	 { 
	 	//var spn  = createSpan(cssRequired ,textReq); 
		 if(checkNode. parentNode.lastChild.id != "neelam")
		{ 
			cs= cssRequired; 
			txt = textReq ;
			append(checkNode,createSpan(cs ,txt));
		}
		
		stat = true; 
	 } 
	
} 
function checkImage(els)
{ 
	
	if (els.value == "")
	{ 
		if(els.parentNode.lastChild.id != "neelam")
		{ 
			cs= cssRequired; 
			txt = textReq ;
			append(els,createSpan(cs,txt ));
		}
		stat = true; 
	}
	else if(!(els.value.match(/(png|jpg|JPG|JPEG|jpeg|gif|PNG|BMP|bmp)$/)))
	{ 
		
		if(els.parentNode.lastChild.id != "neelam")
		{ 
			
			cs  = cssNoImage;
			txt = txtNoImage;
			append(els,createSpan(cs,txt));
		}
		stat = true; 
		
	} 	
} 

function showResultAccordingTotheClassName(elemnt , classNm)
{ 
        
        switch(classNm)
         { 
         
             case "required" :
                                
                               if (elemnt.value == "")
                                 { 
                               	  if(elemnt. parentNode.lastChild.id != "neelam")
                                    { 
                                        cs= cssRequired; 
                                        txt = textReq ;
                                        append(elemnt,createSpan(cs ,txt));
                                    }
                                    
                                    stat = true; 
                                
                                } 
                                break; 
            
            case "number" :       
                                
                                if (elemnt.value.match([" "]) || elemnt.value == "")
                                { 
                                    if(elemnt. parentNode.lastChild.id != "neelam")
                                    { 
                                        cs= cssRequired; 
                                        txt = textReq;
                                        append(elemnt,createSpan(cs ,txt));
                                    }
                                    
                                    stat = true; 
                                } 
                                
                                else if (isNaN(elemnt.value))
                                { 
                                    if(elemnt. parentNode.lastChild.id != "neelam")
                                    { 
                                        cs  = cssNumber; 
                                        txt = textNumber; 
                                        append(elemnt,createSpan(cs,txt));
                                    }
                                    stat = true; 
                                    
                                } 
                                
                                break; 
            
            case "validate" :     
                                if (elemnt.value.match([" "]) || elemnt.value == "")
                                { 
                                    
                                    
                                    if(elemnt. parentNode.lastChild.id != "neelam")
                                    { 
                                        cs= cssRequired;
                                        txt = textReq;
                                        append(elemnt,createSpan(cs,txt ));
                                    }
                                    stat = true; 
                                } 
                                else if(!(elemnt.value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/gi)))
                                { 
                                    
                                    if(elemnt. parentNode.lastChild.id != "neelam")
                                    { 
                                        
                                        cs  = cssNotValid;
                                        txt = textNotValid;
                                        append(elemnt,createSpan(cs,txt));
                                    }
                                    stat = true; 
                                    
                                } 
                                break; 
         }
} 


// splits the class Name with " " if there is more than one class name 
function checkClassName(name)
{ 
    names  = name.split(' ');
    for(var i=0; i < names.length; i++)
    { 
        if (names[i] == 'required' || names[i] == 'validate' || names[i] =='number' || names[i]=='confirm')
        { 
            return names[i]; 
        } 
    } 
}

//removes the alert message if clicked on the textbox 
function remove(pnode,node)
{ 
    //to check if the message if still displayed or not 
   if (pnode.lastChild.id=='neelam')
    { 
        pnode.removeChild(pnode.lastChild);
    } 
    //node.removeAttribute("onclick"); 
    node.select(); 
}
//appends the span that displays the message to next to the textbox
var cnt = 0; 
function append(nd,sps)
{ 
    cnt++; 
	if (cnt ==1)
		{ 
			
			nd.focus();
		} 
    nd.parentNode.appendChild(sps); 
    //nd.setAttribute('onclick','remove(this.parentNode,this)'); 
    nd.onclick = textBoxClick;  
    
    
}

function textBoxClick()
{ 
    remove(this.parentNode, this);
} 
//check the form with id 'prabeen' and adds attribute to  the button which calls the check function on click;

/*window.onload = function()
{ 
    var ids = 'formadmin'; 
	var frms = document.forms[ids]; 
    if (frms)
    { 
        
        for(var i=0; i < frms.length;i++)
        {     
            if (frms.elements[i].type == 'button' || frms.elements[i].type =='submit')
            { 
                //frms.elements[i].setAttribute('onclick',"return checkValue(this.form);"); 
                frms.elements[i].onclick = buttonClick;   
            } 
        } 
    } 
}*/
function buttonClick(my) 
{     
    //alert(my.form);
	return checkValue(my.form);
//return false
} 

function addConfirm()
{
	
	text = $("#password").addClass('confirm');
	text = $("#repassword").addClass('confirm');
	text = $("#username").addClass('required');
	
}