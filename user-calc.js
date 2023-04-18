//BMI Calculations
const options = {
  method: "GET",
  headers: {
    "X-RapidAPI-Key": "675c9e7756mshd98307b74a29b5ap1ea51ejsn1f9a2e25b835",
    "X-RapidAPI-Host": "fitness-calculator.p.rapidapi.com",
  },
};

const age = 25;
const weight = 220; // in kg
const height = 180; // in cm
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
  )
    .then((response) => response.json())
    .then((response) => console.log(response))
    .catch((err) => console.error(err));
}

//ideal weight calculation
async function getIdealWeight() {
    const response = await fetch(
        "https://fitness-calculator.p.rapidapi.com/ideal-weight?age=" + age + "&weight=" + weight, options)
        .then((response) => response.json())
        .then((response) => console.log(response))
        .catch((err) => console.error(err));
}   



