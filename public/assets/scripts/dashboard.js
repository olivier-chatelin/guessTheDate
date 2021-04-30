
const String2Date = response =>{
    let dateItems = response.split("/");
    let year = parseInt(dateItems[2]);
    let month = parseInt(dateItems[1]-1);
    let day = parseInt(dateItems[0]);
    return new Date(year,month,day);
}

const addOneDay = date => {
    date.setDate(date.getDate()+1);
    return date;
}
const convertData = data =>{
    setData(data,setXaxe(data));
}
const setXaxe = data =>{
    let DateA = String2Date(data.startDate);
    let DateB = String2Date(data.endDate);

    let xAxeValues = [];
    while (DateA.toLocaleDateString() !== DateB.toLocaleDateString()){

        xAxeValues.push((DateA).toLocaleDateString());
        DateA = addOneDay(DateA);
    }
    return xAxeValues;
}
const setData = (data , xAxe)=>{
    console.log(data);
    let loginData = [];
    let gameData = [];
    let newPLayerData = [];
    for (const date of xAxe ) {
        (data['logins'][date])? loginData.push(data['logins'][date]):loginData.push(0);
        (data['games'][date])? gameData.push(data['games'][date]):gameData.push(0);
        (data['newPlayers'][date])? newPLayerData.push(data['newPlayers'][date]):newPLayerData.push(0);
    }
    console.log(loginData);
    console.log(gameData);
    console.log(newPLayerData);
    return {
        loginData:loginData,
        gameData:gameData,
        newPLayerData:newPLayerData
    }
}
const drawGraph = data => {
    let yValues = setData(data,setXaxe(data));
    let chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: setXaxe(data),
            datasets:
            [
                {
                    label:'parties jouées',
                    yAxisID: 'A',
                    data: yValues.gameData,
                    lineTension: 0,
                    backgroundColor: '3B1B72',
                    borderColor: '#3B1B72',
                    borderWidth: 4,
                    pointBackgroundColor: '#3B1B72'
            },
                {
                    label:'connexions',
                    yAxisID: 'A',
                    data: yValues.loginData,
                    lineTension: 0,
                    backgroundColor: '#6c757d',
                    borderColor: '#6c757d',
                    borderWidth: 4,
                    pointBackgroundColor: '#6c757d',
                    scalePositionLeft: true

            },
                {
                    label:'nouvelle connexion',
                    yAxisID: 'B',
                    data: yValues.newPLayerData,
                    lineTension: 0,
                    backgroundColor: '#d205df',
                    borderColor: '#d205df',
                    borderWidth: 4,
                    pointBackgroundColor: '#d205df',
                    scalePositionLeft: false
            }
            ]
        },

        options: {
            scales: {
                yAxes: [{
                    id: 'A',
                    type: 'linear',
                    position: 'left',
                }, {
                    id: 'B',
                    type: 'linear',
                    position: 'right',

                }]
            }
        }
    })
}



const ctx = document.getElementById('myChart')
const dateSubmit = document.getElementById('date-submit');
const startDate = document.getElementById('date-start');
const endDate = document.getElementById('date-end');
const displayError = document.getElementById('display-error');

dateSubmit.addEventListener('click',(e) => {
    // e.preventDefault();
    if (!startDate.value || !endDate.value) {
        displayError.innerHTML = 'Veuillez entrer une date valide';
    } else {
        displayError.innerHTML = '';
        const dateData = {
            startDate :startDate.value,
            endDate:endDate.value
        }

        const options = {
            method: 'POST',
            body: JSON.stringify(dateData),
            headers: {
                'Content-Type': 'application/json'
            }
        }
            fetch('/Admin/graphData',options)
            .then(response => response.json())
            .then(data => drawGraph(data));

    }
})

