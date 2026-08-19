---
title: 'Hugging Face Dental Models'
description: 'Open-source models for dental plaque segmentation and imaging'
category: 'AI'
author: 'John Mason'
date: '2026-08-19 12:49'
---

The best open-source AI model architecture for identifying and segmenting teeth plaque (particularly from dental photos) is the **UNet Transformer**, which has been shown to achieve high performance in segmentation tasks with an Intersection over Union (IoU) of 0.7845. For broader dental tasks on Hugging Face, **OralGPT** (specifically versions utilizing Qwen2.5-VL-7B) is a leading open-source multimodal large language model (MLLM) for dental imaging.

## Top Open-Source Models & Architectures

- **UNet Transformer:** Identified as the best-performing model for segmenting dental plaque, superior to standard CNNs in research trials.
- **YOLOv11m / YOLOv9 / YOLOv10:** These, particularly YOLOv11m, have been validated for detecting different types of plaque (new, mature, over-mature) with high accuracy.
- **OralGPT-Omni:** A specialized dental MLLM (open-source) designed for comprehensive analysis of dental images.
- **U-Net (Basic):** Widely used on Hugging Face for semantic segmentation of teeth in panoramic x-ray images.

## Key Resources on Hugging Face

- **OralGPT:** Available via [github.com/isbrycee/OralGPT](https://github.com/isbrycee/OralGPT).
- **AI-in-Dentistry (VGG / YOLOv8 / U-Net):** A repository containing models for calculus, caries, and segmentation.
- **DENTEX Dataset:** A dataset for panoramic X-ray dental diagnosis, suitable for fine-tuning models.
- **Dental Plaque (Roboflow / Hugging Face):** Specifically curated datasets (e.g. `instance-segmentation-dental-plaque`) for fine-tuning, with 70 images / 2 models specifically on plaque.

## Key Considerations

- **Data Quality:** Models trained on images with plaque-disclosing agents provide the most accurate ground truth for segmentation.
- **Evaluation Metric:** The **Intersection over Union (IoU)** is the primary metric for measuring how accurately the model identifies the precise location of plaque.
- **State-of-the-Art:** Recent studies show AI models (specifically UNet Transformer) can perform at or above the level of human experts (dentists) in segmenting plaque.
