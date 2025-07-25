variable "docker_image_name" {
  description = "Nome completo da imagem Docker no Docker Hub (ex: estertavares20205/eleitor-projeto-app)"
  type        = string
}

variable "docker_image_tag" {
  description = "Tag da imagem Docker que será usada para deploy (ex: latest ou número da run)"
  type        = string
}

