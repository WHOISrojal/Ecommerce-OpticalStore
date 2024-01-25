//responsive ko lagi "X" button
const bar = document.getElementById("bar");
const close = document.getElementById("close");
const nav = document.getElementById("navbar");

if(bar){
    bar.addEventListener("click",()=>{
        nav.classList.add("active");
    })
}

if(close){
    close.addEventListener("click",()=>{
        nav.classList.remove("active");
    })
}


//  // Get the person icon element
//  var personIcon = document.getElementById('personIcon');

//  // Get the welcome message
//  var welcomeMessage = "<?php echo $welcomeMessage; ?>";

//  // Add event listeners for mouseover and mouseout
//  personIcon.addEventListener('mouseover', function() {
//    // Show the welcome message when hovering
//    alert(welcomeMessage);
//  });

//  personIcon.addEventListener('mouseout', function() {
//    // You can add code here to hide the message when the mouse moves away
//  });

