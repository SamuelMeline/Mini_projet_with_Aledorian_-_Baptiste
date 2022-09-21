//get lattitude + longitude onLoad  

        const lat = document.querySelector("#lat");
        const long = document.querySelector("#long");  

        console.log(lat);
        console.log(long);
        
        const btnPos = document.querySelector("#btnPos");
        
        if(lat){
            navigator.geolocation.getCurrentPosition((position) => {
                lat.value = position.coords.latitude;
                long.value = position.coords.longitude;
                return position;
            }, (error) => {
                console.error(error);
            });
        }

