function linhaMedia() {
    let tabela = document.getElementById("tabelaNotas");
    let linhas = tabela.rows;
    let colunas = linhas[0].cells.length;
  
    // Evita duplicar a linha de médias
    if (linhas[linhas.length - 1].cells[0].innerText === "Média das Notas") return;
  
    let nova = tabela.insertRow(-1);
    nova.classList.add("total");
    nova.insertCell(0).innerText = "Média das Notas";
  
    for (let c = 1; c < colunas; c++) {
      let soma = 0;
      for (let l = 1; l < linhas.length - 1; l++) {
        soma += Number(linhas[l].cells[c].innerText);
      }
      let media = soma / (linhas.length - 2);
      nova.insertCell(c).innerText = media.toFixed(2);
    }
  }
  
  function colunaMedia() {
    let tabela = document.getElementById("tabelaNotas");
    let linhas = tabela.rows;
    let colunas = linhas[0].cells.length;
  
    // Evita duplicar a coluna de médias
    if (linhas[0].cells[colunas - 1].innerText === "Média") return;
  
    linhas[0].insertCell(-1).outerHTML = "<th>Média</th>";
  
    for (let l = 1; l < linhas.length; l++) {
      let soma = 0;
      for (let c = 1; c < colunas; c++) {
        soma += Number(linhas[l].cells[c].innerText);
      }
      let media = soma / (colunas - 1);
      let celula = linhas[l].insertCell(-1);
      celula.innerText = media.toFixed(2);
      celula.classList.add("total");
    }
  }
  