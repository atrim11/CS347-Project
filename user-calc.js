//BMI Calculations
const options = {
  method: "GET",
  headers: {
    "X-RapidAPI-Key": "675c9e7756mshd98307b74a29b5ap1ea51ejsn1f9a2e25b835",
    "X-RapidAPI-Host": "fitness-calculator.p.rapidapi.com",
  },
};
//need to check if coach and if all data is filled out

//then get the age weight and height from the user

const age = 25;
//will need to multiply weight by 0.45359237
const weight = 150; // in kg
//will need to multiply height by 2.54
const height = 180; // in cm
// get gender 
const gender = "male";
// bmi calculation
async function getBmi() {
  const response = await fetch(
    "https://fitness-calculator.p.rapidapi.com/bmi?age=" +
      age +
      "&weight=" +
      weight +
      "&height=" +
      height,
    options
  );
  var temp = await response.json();
  console.log(temp);
}
getBmi();
//ideal weight calculation
async function getIdealWeight() {
  const response = await fetch(
    "https://fitness-calculator.p.rapidapi.com/idealweight?gender=" +
      gender +
      "&height=" +
      height,
    options
  );
  var temp = await response.json();
  console.log(temp);
}
getIdealWeight();

