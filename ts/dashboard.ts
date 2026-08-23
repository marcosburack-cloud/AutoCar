interface DashboardData {
    agendamentos: number;
}

async function buscarDashboard(): Promise<DashboardData> {
    const resposta = await fetch("api/dashboard.php");

    if (!resposta.ok) {
        throw new Error("Erro ao consultar a API.");
    }

    return await resposta.json();
}

function renderizarDashboard(dados: DashboardData): void {
    const elemento = document.getElementById("totalAgendamentos");

    if (elemento) {
        elemento.textContent = dados.agendamentos.toString();
    }
}

async function carregarDashboard(): Promise<void> {
    try {
        const dados = await buscarDashboard();
        renderizarDashboard(dados);
    } catch (erro) {
        console.error("Erro ao carregar dashboard:", erro);
    }
}

carregarDashboard();