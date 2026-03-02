<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ADV+ CONECTA — Comunidade Jurídica</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --navy:   #0b1628;
            --navy2:  #0f1e38;
            --gold:   #c8a84b;
            --gold2:  #a8893c;
            --white:  #f5f5f0;
            --muted:  #8a9ab5;
        }
        body {
            background-color: var(--navy);
            color: var(--white);
            font-family: 'Inter', sans-serif;
            font-weight: 300;
            line-height: 1.8;
        }
        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
        }
        .gold { color: var(--gold); }
        .bg-gold { background-color: var(--gold); }
        .border-gold { border-color: var(--gold); }

        /* Seções alternadas */
        .section-dark  { background-color: var(--navy); }
        .section-dark2 { background-color: var(--navy2); }

        /* Botão principal */
        .btn-primary {
            display: inline-block;
            background-color: var(--gold);
            color: #0b1628;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.04em;
            padding: 1rem 2.5rem;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.25s, transform 0.2s, box-shadow 0.25s;
            box-shadow: 0 4px 24px rgba(200,168,75,0.25);
        }
        .btn-primary:hover {
            background-color: var(--gold2);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(200,168,75,0.35);
        }

        /* Linha divisória dourada */
        .gold-divider {
            width: 56px;
            height: 2px;
            background-color: var(--gold);
            margin: 0 auto 2rem;
        }

        /* Card de depoimento */
        .testimonial-card {
            background-color: #131f35;
            border-left: 3px solid var(--gold);
            padding: 1.75rem 2rem;
            border-radius: 4px;
        }

        /* Tag de seção */
        .section-tag {
            display: inline-block;
            font-family: 'Inter', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 1.25rem;
        }

        /* Bullet customizado */
        .bullet-item {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            margin-bottom: 0.85rem;
        }
        .bullet-dot {
            flex-shrink: 0;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: var(--gold);
            margin-top: 0.6rem;
        }

        /* Placeholder do vídeo */
        .video-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            background-color: #0f1e38;
            border: 1px solid #1e3155;
            border-radius: 4px;
        }
        .video-wrapper iframe,
        .video-wrapper video {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            border: 0;
        }
        .video-placeholder {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 0.9rem;
            letter-spacing: 0.05em;
        }
        .video-placeholder svg {
            opacity: 0.3;
            margin-bottom: 1rem;
        }

        @media (max-width: 640px) {
            .btn-primary { font-size: 0.95rem; padding: 0.9rem 1.75rem; }
        }
    </style>
</head>
<body>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- TOPO — LOGO                                     --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <header class="section-dark py-8 px-6 flex justify-center">
        <img src="/Logo adv mais.png" alt="ADV+ CONECTA" class="h-20 w-auto opacity-90">
    </header>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- HERO — ABERTURA                                 --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark px-6 pt-16 pb-20">
        <div class="max-w-3xl mx-auto text-center">

            <span class="section-tag">Comunidade Jurídica</span>

            <h1 class="text-3xl md:text-5xl font-bold leading-tight mb-8" style="letter-spacing:-0.01em;">
                Você é advogado e sente que trabalha muito,
                estuda bastante, mas cresce menos do que
                poderia?
            </h1>

            <p class="text-lg md:text-xl text-gray-300 mb-6 leading-relaxed">
                Talvez você já tenha pensado que o problema fosse falta de conhecimento, de cursos ou de esforço.
            </p>
            <p class="text-lg md:text-xl text-gray-300 mb-14 leading-relaxed">
                Mas e se a verdadeira dificuldade não estivesse em você, e sim na forma como a advocacia foi
                estruturada para ser vivida de maneira solitária?
            </p>

            <a href="{{ route('guest.checkout.show') }}" class="btn-primary">
                Quero entrar na comunidade agora
            </a>
            <p class="text-xs mt-3" style="color:var(--muted);">Acesso à assinatura anual</p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- HEADLINE PRINCIPAL                              --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark2 px-6 py-20">
        <div class="max-w-3xl mx-auto text-center">

            <div class="gold-divider"></div>

            <h2 class="text-2xl md:text-4xl font-bold leading-snug mb-8">
                Como crescer na advocacia com mais clareza, segurança e
                resultado, sem depender de tentativa e erro
            </h2>

            <p class="text-base md:text-lg text-gray-300 mb-4 leading-relaxed">
                A maioria dos advogados passa anos estudando, trabalhando duro e tentando acertar sozinha.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-4 leading-relaxed">
                Mesmo assim, muitos continuam inseguros, sobrecarregados e com a sensação constante de que estão
                sempre apagando incêndios.
            </p>
            <p class="text-base md:text-lg text-gray-300 leading-relaxed">
                Isso não acontece por incapacidade. Acontece porque ninguém ensinou um caminho estruturado para
                decidir melhor na prática.
            </p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- VCL — VÍDEO DE CLAREZA                         --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark px-6 py-20">
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-10">
                <span class="section-tag"></span>
                <h3 class="text-xl md:text-2xl font-semibold text-gray-200">
                    Assista antes de continuar
                </h3>
            </div>

            {{-- VÍDEO AQUI --}}
            <div class="video-wrapper mb-8">
                <iframe
                    src="https://www.youtube.com/embed/AvoV-Va2hsE"
                    title="Vídeo de Clareza — ADV+ CONECTA"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>
            </div>

            <p class="text-base md:text-lg text-gray-300 text-center leading-relaxed">
                Neste vídeo, você entende por que tantos advogados se sentem travados, mesmo sendo competentes,
                e qual é a lógica por trás de um crescimento mais seguro e sustentável na advocacia atual.
            </p>

        </div>
    </section>

    {{-- CTA 2 --}}
    <section class="section-dark2 px-6 py-16 text-center">
        <a href="{{ route('guest.checkout.show') }}" class="btn-primary">
            Quero avançar com clareza e apoio real
        </a>
        <p class="text-xs mt-3" style="color:var(--muted);">Acesso à assinatura anual</p>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- PROBLEMA                                        --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark px-6 py-20">
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-12">
                <div class="gold-divider"></div>
                <h2 class="text-2xl md:text-4xl font-bold leading-snug">
                    O problema não é conhecimento.<br>
                    <span class="gold">É isolamento.</span>
                </h2>
            </div>

            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                O maior erro da advocacia moderna não é técnico.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                É tentar tomar decisões importantes sozinho, com informações fragmentadas, pouco apoio prático e
                nenhuma referência real para validar caminhos.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                O modelo tradicional empurra o advogado para o isolamento desde o início da carreira. Cada um
                aprende errando, repetindo estratégias ineficientes e carregando insegurança silenciosa.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                Quando os resultados não aparecem, a culpa parece pessoal. Mas não é.
            </p>
            <p class="text-base md:text-lg text-gray-300 leading-relaxed">
                Sem critério, ambiente e troca, o esforço vira desgaste, o estudo vira confusão e o crescimento fica
                lento e arriscado.
            </p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- SOLUÇÃO                                         --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark2 px-6 py-20">
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-12">
                <div class="gold-divider"></div>
                <h2 class="text-2xl md:text-4xl font-bold leading-snug">
                    A solução não é estudar mais.<br>
                    <span class="gold">É mudar o critério.</span>
                </h2>
            </div>

            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                O crescimento profissional destrava quando o advogado deixa de tentar resolver tudo sozinho e passa
                a decidir dentro de um ambiente estruturado.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                Um ambiente onde existe troca real, validação prática e apoio contínuo.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                Aqui, a inteligência artificial não substitui o advogado, nem promete atalhos milagrosos. Ela entra como
                ferramenta de apoio ao raciocínio, organização de informações, análise de cenários e redução de erros
                repetidos.
            </p>
            <p class="text-base md:text-lg text-gray-300 leading-relaxed">
                Somada à experiência coletiva e à prática compartilhada, a tecnologia deixa de ser moda e passa a ser
                vantagem concreta no dia a dia.
            </p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- CREDIBILIDADE — ANDERSON BARROS                 --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark px-6 py-20">
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-12">
                <div class="gold-divider"></div>
                <span class="section-tag">Por que confiar</span>
            </div>

            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                Eu sou Anderson Barros, advogado, e vivi exatamente esse caminho.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                Comecei na advocacia no isolamento, na tentativa e erro, sem orientação prática, sem referências
                confiáveis e sem apoio real.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                Mesmo estudando, atuando em diferentes áreas e ocupando funções relevantes, o avanço era mais
                lento do que precisava ser.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                Não por falta de capacidade, mas por falta de critério, estrutura e troca.
            </p>
            <p class="text-base md:text-lg text-gray-300 leading-relaxed">
                A comunidade nasce dessa vivência real, não como teoria ou promessa, mas como resposta a um
                problema que se repete diariamente na advocacia brasileira.
            </p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- TRANSFORMAÇÃO — O QUE MUDA                     --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark2 px-6 py-20">
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-12">
                <div class="gold-divider"></div>
                <h2 class="text-2xl md:text-3xl font-bold">
                    O que muda quando você não caminha sozinho
                </h2>
            </div>

            <div class="max-w-md mx-auto mb-10">
                <div class="bullet-item">
                    <span class="bullet-dot"></span>
                    <span class="text-gray-300">Menos decisões no escuro</span>
                </div>
                <div class="bullet-item">
                    <span class="bullet-dot"></span>
                    <span class="text-gray-300">Menos retrabalho</span>
                </div>
                <div class="bullet-item">
                    <span class="bullet-dot"></span>
                    <span class="text-gray-300">Mais clareza para agir</span>
                </div>
                <div class="bullet-item">
                    <span class="bullet-dot"></span>
                    <span class="text-gray-300">Mais segurança para crescer</span>
                </div>
                <div class="bullet-item">
                    <span class="bullet-dot"></span>
                    <span class="text-gray-300">Mais previsibilidade profissional</span>
                </div>
            </div>

            <p class="text-base md:text-lg text-gray-300 text-center leading-relaxed">
                Deixar tudo como está também tem um custo. Ele aparece no tempo perdido, nos erros repetidos e nas
                oportunidades que passam despercebidas.
            </p>

        </div>
    </section>

    {{-- CTA 3 --}}
    <section class="section-dark px-6 py-16 text-center">
        <a href="{{ route('guest.checkout.show') }}" class="btn-primary">
            Quero fazer parte da comunidade
        </a>
        <p class="text-xs mt-3" style="color:var(--muted);">Acesso à assinatura anual</p>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- OFERTA — O QUE VOCÊ RECEBE                      --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark2 px-6 py-20">
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-12">
                <div class="gold-divider"></div>
                <h2 class="text-2xl md:text-4xl font-bold">O que você recebe ao entrar</h2>
            </div>

            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                Ao fazer parte da comunidade, você não compra um curso isolado. Você entra em um ecossistema
                jurídico vivo.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                Você recebe acesso a um ambiente colaborativo ativo, com advogados de diferentes áreas trocando
                experiências reais, discutindo casos, validando decisões e criando oportunidades.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                Além disso, você conta com assistentes de inteligência artificial treinados para a advocacia,
                preparados para apoiar diversos tipos de procedimentos jurídicos, organização de demandas, análise
                de informações e tomada de decisão.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-6 leading-relaxed">
                A tecnologia é apresentada de forma orientada e aplicada à prática, sem tecnicismo desnecessário.
            </p>
            <p class="text-base md:text-lg text-gray-300 leading-relaxed">
                O aprendizado é constante. A comunidade evolui semanalmente, acompanhando novas ferramentas,
                mudanças tecnológicas e necessidades reais da advocacia.
            </p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- BÔNUS                                           --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark px-6 py-20">
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-12">
                <span class="section-tag">Incluído no acesso</span>
                <h2 class="text-2xl md:text-3xl font-bold">Bônus e aprofundamentos</h2>
            </div>

            <p class="text-base md:text-lg text-gray-300 mb-8 leading-relaxed">
                Além do acesso principal, você participa de:
            </p>

            <div class="space-y-4 mb-8">
                <div class="bullet-item">
                    <span class="bullet-dot"></span>
                    <span class="text-gray-300">
                        Treinamentos de prompts avançados, para aprender a conversar melhor com a inteligência
                        artificial e extrair respostas mais úteis e seguras
                    </span>
                </div>
                <div class="bullet-item">
                    <span class="bullet-dot"></span>
                    <span class="text-gray-300">Introdução prática a agentes de IA e automações jurídicas</span>
                </div>
                <div class="bullet-item">
                    <span class="bullet-dot"></span>
                    <span class="text-gray-300">Aulas extras frequentes com professores e advogados de todo o Brasil</span>
                </div>
                <div class="bullet-item">
                    <span class="bullet-dot"></span>
                    <span class="text-gray-300">Atualizações constantes sobre ferramentas, estratégias e soluções jurídicas</span>
                </div>
            </div>

            <p class="text-base md:text-lg text-gray-300 leading-relaxed">
                Esses bônus existem para aprofundar, atualizar e manter a comunidade sempre relevante.
            </p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- PARA QUEM É / NÃO É                             --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark2 px-6 py-20">
        <div class="max-w-3xl mx-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">

                <div>
                    <div class="gold-divider" style="margin-left:0;"></div>
                    <h3 class="text-xl md:text-2xl font-bold mb-6">Para quem é</h3>
                    <p class="text-base text-gray-300 leading-relaxed mb-4">
                        Para advogados que já atuam ou estão iniciando e não querem aprender do jeito mais lento e
                        arriscado: sozinhos.
                    </p>
                    <p class="text-base text-gray-300 leading-relaxed">
                        Serve tanto para quem se sente empacado quanto para quem quer começar a carreira com mais
                        clareza, referência e segurança.
                    </p>
                </div>

                <div>
                    <div style="width:56px;height:2px;background:#374151;margin-bottom:2rem;"></div>
                    <h3 class="text-xl md:text-2xl font-bold mb-6">Para quem não é</h3>
                    <p class="text-base text-gray-300 leading-relaxed mb-4">
                        Não é para quem busca fórmula pronta, promessa fácil ou consumo passivo de conteúdo.
                    </p>
                    <p class="text-base text-gray-300 leading-relaxed">
                        Aqui, crescimento exige participação, troca, aplicação prática e responsabilidade profissional.
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- DEPOIMENTOS                                     --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark px-6 py-20">
        <div class="max-w-3xl mx-auto">

            <div class="text-center mb-12">
                <div class="gold-divider"></div>
                <h2 class="text-2xl md:text-3xl font-bold">O que dizem quem já participa</h2>
            </div>

            <div class="space-y-6">

                <div class="testimonial-card">
                    <p class="text-gray-200 italic leading-relaxed">
                        "A comunidade me tirou do isolamento e mudou completamente minha forma de
                        decidir."
                    </p>
                </div>

                <div class="testimonial-card">
                    <p class="text-gray-200 italic leading-relaxed">
                        "Hoje eu erro menos, ganho tempo e consigo usar tecnologia de forma prática."
                    </p>
                </div>

                <div class="testimonial-card">
                    <p class="text-gray-200 italic leading-relaxed">
                        "Aprendi mais trocando experiências reais do que estudando sozinho por anos."
                    </p>
                </div>

                <div class="testimonial-card">
                    <p class="text-gray-200 italic leading-relaxed">
                        "Tenho mais clareza, segurança e confiança para crescer."
                    </p>
                </div>

            </div>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- GARANTIA                                        --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark2 px-6 py-20">
        <div class="max-w-3xl mx-auto text-center">

            <div class="gold-divider"></div>
            <span class="section-tag">Decisão sem risco</span>
            <h2 class="text-2xl md:text-3xl font-bold mb-8">Garantia</h2>

            <p class="text-base md:text-lg text-gray-300 leading-relaxed">
                Se você entrar, conhecer o ambiente e perceber que isso não faz sentido para o seu momento, não há
                prejuízo.
            </p>
            <p class="text-base md:text-lg text-gray-300 mt-4 leading-relaxed">
                A garantia existe para permitir uma decisão tranquila, sem armadilhas, sem discussões e sem letras
                miúdas.
            </p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- INVESTIMENTO + CTA FINAL                        --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark px-6 py-20">
        <div class="max-w-2xl mx-auto text-center">

            <div class="gold-divider"></div>
            <span class="section-tag">Chamada para ação</span>
            <h2 class="text-2xl md:text-3xl font-bold mb-8">Investimento</h2>

            <p class="text-base md:text-lg text-gray-300 mb-4 leading-relaxed">
                Hoje, o acesso está com valor promocional de
                <span class="gold font-semibold text-xl">R$ 4.999,00</span> na assinatura anual.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-4 leading-relaxed">
                Esse valor existe porque a plataforma ainda está em fase de crescimento e é alimentada semanalmente
                com novos conteúdos, assistentes de IA, treinamentos e trocas práticas.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-4 leading-relaxed">
                Com a evolução natural da estrutura, o valor será reajustado e ficará significativamente mais alto.
            </p>
            <p class="text-base md:text-lg text-gray-300 mb-14 leading-relaxed">
                Colocando em perspectiva, o investimento equivale a menos do que o valor de um almoço por mês.
            </p>

            <a href="{{ route('guest.checkout.show') }}" class="btn-primary text-lg px-10 py-5">
                Quero entrar na assinatura anual por R$ 4.999,00
            </a>
            <p class="text-xs mt-3" style="color:var(--muted);">Acesso à assinatura anual</p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- FECHAMENTO                                      --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <section class="section-dark2 px-6 py-20">
        <div class="max-w-2xl mx-auto text-center">

            <div class="gold-divider"></div>

            <p class="text-lg md:text-xl text-gray-200 mb-4 leading-relaxed font-light">
                Aqui você não compra promessa.
            </p>
            <p class="text-lg md:text-xl text-gray-200 mb-4 leading-relaxed font-light">
                Você entra em um ambiente vivo, com pessoas, tecnologia e critério para decidir melhor.
            </p>
            <p class="text-lg md:text-xl text-gray-200 leading-relaxed font-light">
                Se faz sentido parar de tentar sozinho e crescer com apoio real, o próximo passo está claro.
            </p>

        </div>
    </section>

    {{-- ═══════════════════════════════════════════════ --}}
    {{-- RODAPÉ                                          --}}
    {{-- ═══════════════════════════════════════════════ --}}
    <footer class="section-dark border-t border-slate-800 px-6 py-10 text-center">
        <img src="/Logo adv mais.png" alt="ADV+ CONECTA" class="h-10 w-auto opacity-60 mx-auto mb-4">
        <p class="text-xs" style="color:var(--muted);">
            &copy; {{ date('Y') }} ADV+ CONECTA. Todos os direitos reservados.
        </p>
        <p class="text-xs mt-4" style="color:#2a4570;">
            Desenvolvido por
            <a href="https://wa.me/5582999730532"
               target="_blank"
               rel="noopener"
               style="color:#3a5a80;text-decoration:none;transition:color 0.2s;"
               onmouseover="this.style.color='var(--gold)'"
               onmouseout="this.style.color='#3a5a80'">
                Flávio Henrique
            </a>
        </p>
    </footer>

</body>
</html>
