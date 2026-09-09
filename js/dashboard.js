"use strict";
async function buscarDashboard() {
    const resposta = await fetch("/automotivoscar/api/dashboard.php");
    if (!resposta.ok) {
        throw new Error("Erro ao consultar a API.");
    }
    return await resposta.json();
}
function atualizarElemento(id, valor) {
    const elemento = document.getElementById(id);
    if (elemento !== null) {
        elemento.textContent = valor;
    }
}
function renderizarDashboard(dados) {
    const faturamento = dados.dadosAgendamentos.reduce((total, agendamento) => {
        const preco = Number(agendamento.preco_servico);
        if (Number.isNaN(preco)) {
            return total;
        }
        return total + preco;
    }, 0);
    const agendamentosFuturos = dados.dadosAgendamentos.filter((agendamento) => {
        return agendamento.data_agendamento >=
            new Date().toISOString().split("T")[0];
    });
    const listaServicos = dados.dadosAgendamentos.map((agendamento) => {
        return agendamento.nome_servico;
    });
    atualizarElemento("agendamentosFuturos", String(agendamentosFuturos.length));
    atualizarElemento("listaServicos", listaServicos.length > 0
        ? listaServicos.join(", ")
        : "Nenhum serviço");
    atualizarElemento("totalAgendamentos", String(dados.agendamentos));
    atualizarElemento("totalServicos", String(dados.servicos));
    atualizarElemento("totalProdutos", String(dados.produtos));
    atualizarElemento("faturamento", faturamento.toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL"
    }));
    atualizarElemento("servicoMaisAgendado", dados.servicoMaisAgendado);
}
async function carregarDashboard() {
    try {
        const dados = await buscarDashboard();
        renderizarDashboard(dados);
    }
    catch (erro) {
        console.error("Erro ao carregar dashboard:", erro);
    }
}
carregarDashboard();
