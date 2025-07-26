terraform {
  required_providers {
    koyeb = {
      source  = "koyeb/koyeb"
      version = "~> 0.1.0"
    }
  }
}

provider "koyeb" {
}

resource "koyeb_service" "eleitor" {
  app_name = "eleitor-projeto"            

  definition {
    name = "web"
    regions = ["aws-us-east-1"]

    docker {
      image = "${var.docker_image_name}:${var.docker_image_tag}"
    }

    ports {
      port     = 80
      protocol = "http"
    }

    routes {
      path = "/"
      port = 80
    }
    instance_types {
      type = 	"xlarge-1x" 
    }
    scalings {
      min = 1
      max = 1
    }
  }
}
