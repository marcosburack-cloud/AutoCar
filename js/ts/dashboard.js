"use strict";
async function carregarDashboard() {
    try {
        const resposta = await fetch("../api/dashboard.php");
        if (!resposta.ok) {
            throw new Error("Erro ao consultar a API.");
        }
        const dados = await resposta.json();
        console.log("Total de agendamentos:", dados.agendamentos);
    }
    catch (erro) {
        console.error("Erro ao carregar dashboard:", erro);
    }
}
carregarDashboard();
