let campo = document.getElementById("resultado");

function digitar(valor) {
  if (campo.value === "0" || campo.value === "Erro") {
    campo.value = valor;
  } else {
    campo.value += valor;
  }
}

function limpar() {
  campo.value = "0";
  campo.style.background = "#eaeaea";
}

function calcular() {
  let expressao = campo.value;
  let res = 0;

  if (expressao.includes("+")) {
    let partes = expressao.split("+");
    res = parseFloat(partes[0]) + parseFloat(partes[1]); // ADIÇÃO
  } 
  else if (expressao.includes("-")) {
    let partes = expressao.split("-");
    res = parseFloat(partes[0]) - parseFloat(partes[1]); // SUBTRAÇÃO
  } 
  else if (expressao.includes("*")) {
    let partes = expressao.split("*");
    res = parseFloat(partes[0]) * parseFloat(partes[1]); // MULTIPLICAÇÃO
  } 
  else if (expressao.includes("/")) {
    let partes = expressao.split("/");
    if (parseFloat(partes[1]) === 0) {
      campo.value = "Erro: divisão por 0";
      campo.style.background = "lightgray";
      return;
    }
    res = parseFloat(partes[0]) / parseFloat(partes[1]); // DIVISÃO
  }

  campo.value = res;

  // Cores do resultado
  if (res > 0) campo.style.background = "lightgreen";
  else if (res < 0) campo.style.background = "lightcoral";
  else campo.style.background = "lightgray";
}
