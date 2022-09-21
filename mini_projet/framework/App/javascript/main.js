//get lattitude + longitude onLoad  

        navigator.geolocation.getCurrentPosition((position) => {
            console.log("latitude " + position.coords.latitude);
            console.log("longitude " + position.coords.longitude);
        }, (error) => {
            console.error(error);
        });

        const input1 = querySelector("#input1");
        const input2 = querySelector("#input2");        
        button.addEventListener('click', () =>{
            input1.value = position.coords.latitude;
            input2.value = position.coords.longitude;
        })
