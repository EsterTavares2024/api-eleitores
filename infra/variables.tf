# Token de acesso para autenticar com a API da Koyeb
variable "koyeb_token" {
  description = "Token da Koyeb para autenticação"
  type        = string
  sensitive   = true
}

# Nome completo da imagem Docker no Docker Hub (ex: usuario/nome-do-app)
variable "docker_image_name" {
  description = "Nome da imagem Docker no Docker Hub"
  type        = string
}

# Tag da imagem Docker (ex: latest, 1.0.3, SHA, etc)
variable "docker_image_tag" {
  description = "Tag da imagem Docker a ser usada"
  type        = string
}

# Nome do serviço no Koyeb
variable "service_name" {
  description = "Nome do serviço na Koyeb"
  type        = string
  default     = "eleitor-projeto-app"
}

# Região opcional para o deploy (padrão: Frankfurt)
variable "region" {
  description = "Região do deploy na Koyeb (ex: frankfurt, virginia)"
  type        = string
  default     = "frankfurt"
}

    # Usuário do Docker Hub para autenticar (opcional para imagens públicas)
variable "docker_user" {
  description = "Usuário Docker Hub para pull da imagem"
  type        = string
  default     = "estertavares2025"
}

variable "docker_pass" {
  description = "Senha/token Docker Hub para pull"
  type        = string
  sensitive   = true
}

