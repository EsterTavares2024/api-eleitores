variable "docker_image_name" {
  description = "Nome completo da imagem Docker no Docker Hub (ex: estertavares2025/eleitor-projeto)"
  type        = string
}

variable "docker_image_tag" {
  description = "Tag da imagem Docker que será usada para deploy (ex: 1.0.1)"
  type        = string
}

variable "koyeb_token" {
  description = "Token de acesso à API da Koyeb"
  type        = string
  sensitive   = true
}

