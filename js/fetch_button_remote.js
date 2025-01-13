function GetButtonRemote (valuebtn) {
    let btn_el = document.getElementById(valuebtn); 
    let device_id = btn_el.dataset.deviceId;
        
    if (valuebtn == "button_power") {
        Update_Button(device_id,'power');
    }
    if (valuebtn == "button_plus") {
        Update_Button(device_id, 'plus');
    }
    if (valuebtn == "button_reduce") {
        Update_Button(device_id, 'reduce');
    }
    if (valuebtn == "button_moveUp") {
        Update_Button(device_id, 'moveUp');
    }
     if (valuebtn == "button_moveDown") {
        Update_Button(device_id, 'moveDown');
    }
    if (valuebtn == "button_up") {
        Update_Button(device_id, 'up');
    }
    if (valuebtn == "button_left") {
        Update_Button(device_id, 'left');
    }
    if (valuebtn == "button_ok") {
        Update_Button(device_id, 'ok');
    }
    if (valuebtn == "button_right") {
        Update_Button(device_id, 'right');
    }
    if (valuebtn == "button_down") {
        Update_Button(device_id, 'down');
    }
   
}

function Update_Button(device_id, value) {

    const data = {
        device_id: device_id,
        value: value
    };

    fetch("../controllers/remote_insert.php", {
            method: "POST",
            headers: {
                "Content-type": "application/json",
            },
            body: JSON.stringify(data) 
        })
        .then(response => response.json())
        .then(data => {
            console.log("Response from server:", data);
        })
        .catch(error => {
            console.error("Fetch error:", error);
        });
}