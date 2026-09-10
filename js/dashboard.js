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
        if (!agendamento.data_agendamento) {
            return false;
        }
        return agendamento.data_agendamento >=
            new Date().toISOString().split("T")[0];
    });
    const listaServicos = dados.dadosAgendamentos.map((agendamento) => {
        return agendamento.nome_servico;
    })
        .filter((nomeServico) => nomeServico.trim() !== "");
    const frequenciaServicos = {};
    dados.dadosAgendamentos.forEach((agendamento) => {
        const nomeServico = agendamento.nome_servico;
        if (nomeServico === "") {
            return;
        }
        if (!frequenciaServicos[nomeServico]) {
            frequenciaServicos[nomeServico] = 0;
        }
        frequenciaServicos[nomeServico]++;
    });
    let servicoMaisAgendado = "Nenhum";
    const servicosOrdenados = Object.keys(frequenciaServicos).sort((a, b) => frequenciaServicos[b] - frequenciaServicos[a]);
    if (servicosOrdenados.length > 0) {
        servicoMaisAgendado = servicosOrdenados[0];
    }
    atualizarElemento("servicoMaisAgendado", servicoMaisAgendado);
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
