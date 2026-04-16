<?php

namespace Database\Seeders;

use App\Models\OnboardingSetting;
use Illuminate\Database\Seeder;

class OnboardingSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            'welcome_subject' => 'Bem-vindo(a) à ADV+ CONECTA!',

            'welcome_message' => '<p>Olá, <strong>{{nome}}</strong>!</p>

<p>É com grande satisfação que damos as boas-vindas à <strong>ADV+ CONECTA</strong>!</p>

<p>Sua assinatura foi confirmada com sucesso. Agora você faz parte de uma comunidade exclusiva de profissionais do Direito, com acesso a conteúdos, cursos e trilhas de aprendizado de alto nível.</p>

<p>Para concluir seu cadastro como membro, precisamos que você:</p>
<ol>
  <li>Leia e assine o <strong>Termo de Adesão</strong> em anexo (PDF) e nos envie de volta;</li>
  <li>Envie sua <strong>foto profissional</strong>;</li>
  <li>Envie seu <strong>mini currículo</strong>;</li>
  <li>Informe seu <strong>número da OAB</strong>.</li>
</ol>

<p>Clique no botão abaixo para preencher o formulário rapidamente:</p>

<p style="text-align:center;">
  <a href="{{link_formulario}}" style="background:#1d4ed8;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:bold;display:inline-block;">
    Enviar meus documentos
  </a>
</p>

<p>Se tiver qualquer dúvida, entre em contato pelo WhatsApp: <a href="https://wa.me/5582993678371">+55 82 99367-8371</a></p>

<p>Bem-vindo(a) à família ADV+ CONECTA!</p>

<p><strong>Equipe ADV+ CONECTA</strong></p>',

            'term_content' => '<h2 style="text-align:center;">TERMO DE ADESÃO</h2>
<h3 style="text-align:center;">ADV+ CONECTA</h3>

<p style="text-align:center;"><strong>Data:</strong> {{data}}</p>

<p>Pelo presente instrumento, o(a) profissional abaixo qualificado(a), doravante denominado(a) <strong>MEMBRO</strong>, adere voluntariamente à plataforma <strong>ADV+ CONECTA</strong>, administrada por Flávio Henrique, concordando integralmente com os termos e condições a seguir:</p>

<h4>1. OBJETO</h4>
<p>O presente termo regula a adesão do MEMBRO à plataforma ADV+ CONECTA, uma comunidade digital voltada a profissionais do Direito, com acesso a cursos, trilhas de aprendizado, materiais e conteúdos jurídicos exclusivos.</p>

<h4>2. PLANO CONTRATADO</h4>
<p>O MEMBRO contratou o <strong>Plano Anual da Plataforma ADV+ CONECTA</strong>, com vigência de 12 (doze) meses a partir da confirmação do pagamento, podendo ser renovado conforme condições vigentes.</p>

<h4>3. OBRIGAÇÕES DO MEMBRO</h4>
<p>O MEMBRO se compromete a:</p>
<ul>
  <li>Utilizar a plataforma exclusivamente para fins pessoais e profissionais lícitos;</li>
  <li>Não compartilhar suas credenciais de acesso com terceiros;</li>
  <li>Respeitar os direitos autorais dos conteúdos disponibilizados;</li>
  <li>Manter seus dados cadastrais atualizados.</li>
</ul>

<h4>4. OBRIGAÇÕES DA ADV+ CONECTA</h4>
<p>A ADV+ CONECTA se compromete a:</p>
<ul>
  <li>Disponibilizar acesso aos conteúdos e funcionalidades contratados durante a vigência do plano;</li>
  <li>Manter a confidencialidade dos dados pessoais do MEMBRO.</li>
</ul>

<h4>5. CANCELAMENTO</h4>
<p>O cancelamento poderá ser solicitado a qualquer momento, sem direito a reembolso proporcional, encerrando-se o acesso ao término do período já pago.</p>

<h4>6. DISPOSIÇÕES GERAIS</h4>
<p>O presente termo é regido pelas leis da República Federativa do Brasil. Fica eleito o foro da comarca de Maceió/AL para dirimir eventuais controvérsias.</p>

<br>
<p>____________________________________<br>
<strong>Nome:</strong> {{nome}}<br>
<strong>E-mail:</strong> {{email}}<br>
<strong>OAB:</strong> ___________<br>
<strong>Data:</strong> {{data}}</p>

<br>
<p style="text-align:center;font-size:12px;color:#666;">ADV+ CONECTA — contato: adv+conecta@advconecta.com.br</p>',
        ];

        foreach ($settings as $key => $value) {
            OnboardingSetting::set($key, $value);
        }
    }
}
