interface Agendamento {
    id_agendamento: number;
    nome_cliente: string;
    telefone: string;
    modelo_carro: string;
    placa: string;
    id_servico: number;
    nome_servico: string;
    preco_servico: string;
    data_agendamento: string;
    hora_agendamento: string;
}

interface DashboardData {
    agendamentos: number;
    servicos: number;
    produtos: number;
    faturamento: number;
    servicoMaisAgendado: string;
    dadosAgendamentos: Agendamento[];
}

async function buscarDashboard(): Promise<DashboardData> {
    const resposta: Response = await fetch(
        "/automotivoscar/api/dashboard.php"
    );

    if (!resposta.ok) {
        throw new Error("Erro ao consultar a API.");
    }

    return await resposta.json() as DashboardData;
}

function atualizarElemento(
    id: string,
    valor: string
): void {

    const elemento: HTMLElement | null =
        document.getElementById(id);

    if (elemento !== null) {
        elemento.textContent = valor;
    }
}

function renderizarDashboard(
    dados: DashboardData
): void {

    const faturamento: number = dados.dadosAgendamentos.reduce(
        (total: number, agendamento: Agendamento): number => {
            const preco: number = Number(agendamento.preco_servico);

            if (Number.isNaN(preco)) {
                return total;
            }

            return total + preco;
        },
        0
    );
    const agendamentosFuturos: Agendamento[] =
    dados.dadosAgendamentos.filter(
        (agendamento: Agendamento): boolean => {

            if (!agendamento.data_agendamento) {
                return false;
            }

            return agendamento.data_agendamento >=
                new Date().toISOString().split("T")[0];
        }
    );
   const listaServicos: string[] =
    dados.dadosAgendamentos.map(
            (agendamento: Agendamento): string => {
                return agendamento.nome_servico;
            }
        )
        .filter(
            (nomeServico: string): boolean =>
                nomeServico.trim() !== ""
        );
    const frequenciaServicos: Record<string, number> = {};

dados.dadosAgendamentos.forEach(
    (agendamento: Agendamento): void => {
        const nomeServico: string = agendamento.nome_servico;

        if (nomeServico === "") {
            return;
        }

        if (!frequenciaServicos[nomeServico]) {
            frequenciaServicos[nomeServico] = 0;
        }

        frequenciaServicos[nomeServico]++;
    }
);

let servicoMaisAgendado: string = "Nenhum";

const servicosOrdenados: string[] = Object.keys(
    frequenciaServicos
).sort(
    (a: string, b: string): number =>
        frequenciaServicos[b] - frequenciaServicos[a]
);

if (servicosOrdenados.length > 0) {
    servicoMaisAgendado = servicosOrdenados[0];
}
atualizarElemento(
    "servicoMaisAgendado",
    servicoMaisAgendado
);
atualizarElemento(
    "agendamentosFuturos",
    String(agendamentosFuturos.length)
);
atualizarElemento(
    "listaServicos",
    listaServicos.length > 0
        ? listaServicos.join(", ")
        : "Nenhum serviço"
);
    atualizarElemento(
        "totalAgendamentos",
        String(dados.agendamentos)
    );

    atualizarElemento(
        "totalServicos",
        String(dados.servicos)
    );

    atualizarElemento(
        "totalProdutos",
        String(dados.produtos)
    );

    atualizarElemento(
        "faturamento",
        faturamento.toLocaleString(
            "pt-BR",
            {
                style: "currency",
                currency: "BRL"
            }
        )
    );

    atualizarElemento(
        "servicoMaisAgendado",
        dados.servicoMaisAgendado
    );
}
async function carregarDashboard(): Promise<void> {

    try {

        const dados: DashboardData =
            await buscarDashboard();

        renderizarDashboard(dados);

    } catch (erro: unknown) {

        console.error(
            "Erro ao carregar dashboard:",
            erro
        );
    }
}

carregarDashboard();