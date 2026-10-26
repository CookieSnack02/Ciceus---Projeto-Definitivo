# Ciceus para Android

App Android do Ciceus. Ele abre o site (https://www.ciceus.com) em tela cheia,
dentro de uma WebView, sem a barra do navegador. Tudo o que aparece vem do
servidor, então qualquer melhoria no site já chega ao app sem publicar uma
versão nova.

## Como abrir

1. No Android Studio: **File → Open** e escolha esta pasta `android/`, não a raiz do repositório.
2. Espere o **Gradle Sync** terminar. Na primeira vez ele baixa o Gradle 8.9 e as dependências.
3. Se o Android Studio oferecer atualizar o AGP ou o Gradle, pode aceitar.
4. Escolha um emulador ou um celular com a depuração USB ligada e clique em **Run ▶**.

O projeto não traz o `gradlew` nem o `gradle-wrapper.jar`. O Android Studio
não precisa deles: ele usa o `gradle/wrapper/gradle-wrapper.properties`.
Para compilar pelo terminal, gere o wrapper uma vez com `gradle wrapper`.

## O que o app faz além do site

| Recurso | Onde está |
|---|---|
| Botão voltar do Android volta a página do site | `configurarBotaoVoltar()` |
| Links de outros sites abrem no navegador | `shouldOverrideUrlLoading()` |
| Inserir imagem na nota abre o seletor de arquivos | `onShowFileChooser()` |
| Tela "Sem conexão" com botão de tentar de novo | `onReceivedError()` + `activity_main.xml` |
| Barra de carregamento no topo | `onProgressChanged()` |
| Girar a tela não recarrega a página (não perde a nota) | `configChanges` no `AndroidManifest.xml` |
| Ícone adaptativo com o logo do Ciceus | `res/drawable/ic_launcher_foreground.xml` |

O site identifica o app pelo `CiceusApp/1.0` no final do user-agent.

## Trocar o servidor

O endereço fica em `app/build.gradle.kts`, nos campos `URL_INICIAL` e `DOMINIO`.

## Versão para a Play Store

**Build → Generate Signed App Bundle / APK**. A chave de assinatura (`.jks`)
nunca vai para o repositório: ela já está no `.gitignore`. Guarde-a bem,
porque sem ela não dá para publicar atualizações do app.
