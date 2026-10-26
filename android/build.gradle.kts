// configuracao comum a todos os modulos. os plugins sao declarados aqui
// sem aplicar ("apply false") e aplicados de fato no app/build.gradle.kts
plugins {
    alias(libs.plugins.android.application) apply false
    alias(libs.plugins.kotlin.android) apply false
}
